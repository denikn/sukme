<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Validator;

use App\Sip_trx_form_submission;
use App\Sip_ref_activity;
use App\Sip_ref_form;
use App\Sip_trx_form_value;
use App\Sip_trx_user_config;
use App\Sip_trx_user_log;

class MemberController extends Controller
{

/*    public function __construct()
    {
        $this->middleware('auth:user');
    }*/
    
    public function index()
    {

        $submissions = Sip_trx_form_submission::orderBy('created_at','DESC')->paginate(10);
        return view('user.main',compact('submissions'));
    
    }
    
    public function index_activity()
    {   

        // chec user config
        $logs = Sip_trx_user_log::paginate(20);

        return view('user.activity',compact('logs'));
    }

    public function view_profile()
    {   

        // chec user config
        $config = Sip_trx_user_config::where('sip_trx_user_configs_user_id',Auth::user()->user_id)->first();

        if(!is_object($config)){

            $input = array(
                
                'sip_trx_user_configs_trf_data_type' => 'single',
                'sip_trx_user_configs_user_id' => Auth::user()->user_id

                );

            $config = Sip_trx_user_config::create($input);

        }

        return view('user.profile',compact('config'));
    }

    public function index_pelaporan()
    {
        return view('user.main');
    }

    public function index_generate_activity_member(Request $request)
    {   
        
        $activities = Sip_ref_activity::where('sip_ref_activities_status','active')->get();
        $user = Auth::user();
        $from = $request->input('from');
        $to = $request->input('to');

        $last = strtotime($from); 
        $next = strtotime($to);

        if(trim($from) !== '' && trim($to) !== ''){

            foreach($activities as $activity){
                
                $tmpForms = [];                
                foreach($activity->forms()->where('sip_ref_forms_status','active')->get() as $form){
                    
                    $subs = $form->subs;
                    foreach($subs as $sub){
                        
                        // get columns
                        $tmpColumns = $sub->columns;

                        // get row
                        $tmpRows = $sub->rows()->where('sip_ref_rows_type_row','row')->get();

                        foreach($tmpColumns as $col){

                            foreach($tmpRows as $row){

                                $row['value'] = $form->values()->join('sip_trx_form_submissions','sip_trx_form_submissions.sip_trx_form_submission_id','=','sip_trx_form_values.sip_trx_form_values_submission_id')
                                                ->join('sip_trx_row_values','sip_trx_row_values.sip_trx_row_values_code','=','sip_trx_form_values.sip_trx_form_values_code')
                                                ->where('sip_trx_form_submissions.sip_trx_form_submission_user_id',$user->user_id)
                                                ->where('sip_trx_row_values.sip_trx_row_values_column_id',$col->sip_ref_columns_id)
                                                ->where('sip_trx_row_values.sip_trx_row_values_column_id',$col->sip_ref_columns_id)
                                                ->where('sip_trx_row_values.sip_trx_row_values_row_id',$row->sip_ref_rows_id)
                                                ->where('sip_trx_form_values.created_at','>=',date('Y-m-d', $last))
                                                ->where('sip_trx_form_values.created_at','<=',date('Y-m-d', $next))
                                                ->sum('sip_trx_form_values_value_string');                        

                            }

                        }

                        unset($sub['rows']);
                        $sub['rows'] = $tmpRows; 

                    }

                    $tmpForms[] = $form;
                } 
            
                unset($activity['forms']);
                $activity['forms'] = $tmpForms; 
            
            }
        }

        $logs = Sip_trx_user_log::where('sip_trx_user_logs_user_id',$user->user_id)
                                ->where('sip_trx_user_logs_type','generate-submission-offline')
                                ->orderBy('sip_trx_user_logs_id','DESC')
                                ->paginate(10);

        return view('user.report.index_send_report_member',compact('activities','user','logs'));
    
    }

    public function index_activity_member($id,Request $request)
    {
        
        $form = [];
        $subs = [];
        $user = Auth::user();

        $activity = Sip_ref_activity::find($id);

        if(!is_object($activity))
            return redirect('member/dashboard');

        if(trim($request->input('sip_ref_forms_id')) !== ''){

            $form = Sip_ref_form::find($id);

            $subs = $form->subs;
            foreach($subs as $sub){
                
                // get columns
                $tmpColumns = $sub->columns;

                // get row
                $tmpRows = $sub->rows()->where('sip_ref_rows_type_row','row')->get();

                foreach($tmpColumns as $col){

                    foreach($tmpRows as $row){

                        $row['value'] = $form->values()->join('sip_trx_form_submissions','sip_trx_form_submissions.sip_trx_form_submission_id','=','sip_trx_form_values.sip_trx_form_values_submission_id')
                                        ->join('sip_trx_row_values','sip_trx_row_values.sip_trx_row_values_code','=','sip_trx_form_values.sip_trx_form_values_code')
                                        ->where('sip_trx_form_submissions.sip_trx_form_submission_user_id',$user->user_id)
                                        ->where('sip_trx_row_values.sip_trx_row_values_column_id',$col->sip_ref_columns_id)
                                        ->where('sip_trx_row_values.sip_trx_row_values_column_id',$col->sip_ref_columns_id)
                                        ->where('sip_trx_row_values.sip_trx_row_values_row_id',$row->sip_ref_rows_id)
                                        ->sum('sip_trx_form_values_value_string');                        

                    }

                }

                $sub['rows'] = $tmpRows; 

            }

        }


        return view('user.report.index_report_member', compact('activity','form','subs','user'));
    }
}
