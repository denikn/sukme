<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Chumper\Zipper\Zipper;
use App\Helpers\CustomHelper;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;

use App\Sip_ref_activity;
use App\Sip_ref_form;
use App\Sip_ref_sub_form;
use App\Sip_ref_column;
use App\Sip_ref_row;
use App\Sip_trx_row_value;
use App\Sip_trx_form_value;
use App\Sip_trx_form_submission;
use App\Sip_trx_user_log;

class FormController extends Controller
{

    public function detail_admin_subform($id,$sub)
    {   
        
        $form = Sip_ref_form::find($id);
        $sub = Sip_ref_sub_form::find($sub);

        return view('admin.subform.detail_subform_data',compact('form','sub'));

    }
    
    public function view_form_value($id)
    {   
        
        $form = Sip_ref_form::find($id);
        $activity = $form->activity;

        $subs = $form->subs;
        foreach($subs as $sub){
            
            // get row
            $tmpRows = $sub->rows()->where('sip_ref_rows_type_row','row')->get();

            foreach($tmpRows as $row){
                
                //get row columns
                $tmpCodes = $row->codes;
                
                foreach($tmpCodes as $code){

                    $code['value'] = Sip_trx_form_value::where('sip_trx_form_values_code',$code->sip_trx_row_values_code)->get();

                }   
                                             
                $row['values'] = $tmpCodes;
                
                unset($row['codes']);

            }

            $sub['rows'] = $tmpRows; 

        }

        return view('admin.value.view_form_value_index',compact('form','subs','activity'));

    }

    /* 
        
        Member Area 
        @

    */

    public function view_form_value_member($id)
    {   
        
        $form = Sip_ref_form::find($id);

        $submissions = $form->submissions()->paginate(20);

        return view('user.pelaporan.index_pelaporan',compact('form','submissions'));

    }

    public function create_form_member($id){
        
        $form = Sip_ref_form::find($id);
        
        return view('user.pelaporan.create_pelaporan',compact('form','subs'));

    }   

    public function view_submisi_member($id,$sub){
        
        $form = Sip_ref_form::find($id);
        $submission = Sip_trx_form_submission::find($sub);

        return view('user.pelaporan.view_submisi_data',compact('form','submission'));

    }   

    public function index_subform($id)
    {   
        
        $form = Sip_ref_form::find($id);

        return view('admin.form.detail_form_data',compact('form'));
    }
    
    public function add_subform_proses($id,Request $request){

        $input = array(
            
            'sip_ref_sub_forms_title' => $request->input('sip_ref_sub_forms_title'),
            'sip_ref_sub_forms_form_id' => $id,
            'sip_ref_sub_forms_send_type' => $request->input('sip_ref_sub_forms_send_type'),
            'sip_ref_sub_forms_show_type' => $request->input('sip_ref_sub_forms_show_type'),
            'sip_ref_sub_forms_report_show' => $request->input('sip_ref_sub_forms_report_show')

            );

        $validator = Validator::make($input, [
            
            'sip_ref_sub_forms_title' => 'required',
            'sip_ref_sub_forms_form_id' => 'required',
            'sip_ref_sub_forms_send_type' => 'required',
            'sip_ref_sub_forms_show_type' => 'required',
            'sip_ref_sub_forms_report_show' => 'required'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','addSubform')
                        ->with('id',$id)
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        Sip_ref_sub_form::insert($input);
        
        return back()
                    ->with('status',1)
                    ->with('message','Success');

    }
    
    public function update_subform_proses($id,Request $request){

        $sub = Sip_ref_sub_form::find($id);

        if(!is_object($sub))             
            return back()
                        ->with('type','updateSubform')
                        ->with('message','Data not found')
                        ->with('id',$id)
                        ->with('status',0);

        $input = array(
            
            'sip_ref_sub_forms_title' => $request->input('sip_ref_sub_forms_title'),
            'sip_ref_sub_forms_send_type' => $request->input('sip_ref_sub_forms_send_type'),
            'sip_ref_sub_forms_show_type' => $request->input('sip_ref_sub_forms_show_type'),
            'sip_ref_sub_forms_report_show' => $request->input('sip_ref_sub_forms_report_show')

            );

        $validator = Validator::make($input, [
            
            'sip_ref_sub_forms_title' => 'required',
            'sip_ref_sub_forms_send_type' => 'required',
            'sip_ref_sub_forms_show_type' => 'required',
            'sip_ref_sub_forms_report_show' => 'required'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','updateSubform')
                        ->with('id',$id)
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $sub->update($input);
        
        return back()
                    ->with('status',1)
                    ->with('message','Success');

    }
    
    public function delete_subform_proses($id,Request $request){

        $sub = Sip_ref_sub_form::find($id);

        if(!is_object($sub))             
            return back()
                        ->with('type','deleteSubform')
                        ->with('message','Data not found')
                        ->with('id',$id)
                        ->with('status',0);

        $input = array(
            
            'sip_ref_sub_forms_status' => 'inactive'

            );

        $sub->update($input);
        
        return back()
                    ->with('status',1)
                    ->with('message','Success');

    }

    public function add_column_proses($id,$sub,Request $request){

        $input = array(
            
            'sip_ref_columns_title' => $request->input('sip_ref_columns_title'),
            'sip_ref_columns_sub_id' => $sub,
            'sip_ref_columns_show_title' => trim($request->input('sip_ref_columns_show_title')) !== '' ? 1 : 0,
            'sip_ref_columns_group_id' => $request->input('sip_ref_columns_group_id'),
            'sip_ref_columns_val_type' => $request->input('sip_ref_columns_val_type')

            );

        if($request->input('sip_ref_columns_parent_id')){
            
            $input['sip_ref_columns_parent_id'] = $request->input('sip_ref_columns_parent_id');
            $input['sip_ref_columns_parent_type'] = 'child';
            
        }

        $validator = Validator::make($input, [
            
            'sip_ref_columns_group_id' => 'required',
            'sip_ref_columns_sub_id' => 'required',
            'sip_ref_columns_title' => 'required'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','addColumn')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        Sip_ref_column::insert($input);
        
        return back()
                    ->with('status',1)
                    ->with('message','Success');

    }

    public function add_admin_group_proses($id,$sub,Request $request){

        $input = array(
            
            'sip_ref_rows_title' => $request->input('sip_ref_rows_title'),
            'sip_ref_rows_sub_id' => $sub,
            'sip_ref_rows_type_row' => 'group'

            );

        $row = Sip_ref_row::create($input);
        
        return back()
                    ->with('status',1)
                    ->with('message','Success');

    }

    public function add_row_proses($id,$sub,Request $request){

        $input = array(
            
            'sip_ref_rows_title' => $request->input('sip_ref_rows_title'),
            'sip_ref_rows_sub_id' => $sub,
            'sip_ref_rows_show_title' => trim($request->input('sip_ref_rows_show_title')) !== '' ? 1 : 0,
            'sip_ref_rows_group_id' => $request->input('sip_ref_rows_group_id')

            );

        if($request->input('sip_ref_rows_parent_id')){
            
            $input['sip_ref_rows_parent_id'] = $request->input('sip_ref_rows_parent_id');
            $input['sip_ref_rows_type_parent'] = 'child';
            
        }

        $validator = Validator::make($input, [
            
            'sip_ref_rows_group_id' => 'required',
            'sip_ref_rows_sub_id' => 'required',
            'sip_ref_rows_title' => 'required'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','addRow')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $row = Sip_ref_row::create($input);
        
        /* get cols for the sub */
        $cols =  $request->input('sip_trx_row_values_code');

        $i=0;
        foreach($cols as $data){
            
            if(trim($data) !== ''){
                
                //store row values
                $inputRV = array(
                    
                    'sip_trx_row_values_code' => $data,
                    'sip_trx_row_values_row_id' => $row->sip_ref_rows_id,
                    'sip_trx_row_values_column_id' => $request->input('sip_trx_row_values_column_id')[$i]

                    );

                Sip_trx_row_value::create($inputRV);    
                            
            }

            $i++;
        }

        return back()
                    ->with('status',1)
                    ->with('message','Success');

    }

    public static function generateRowCode($sub,$cols,$row){

    }

    public function index_form()
    {   
        
        $activities = Sip_ref_activity::all();
        $forms = Sip_ref_form::paginate(10);

        return view('admin.form.view_form_data',compact('activities','forms'));
    }

    public function add_admin_form_proses(Request $request){

        $input = array(
            
            'sip_ref_forms_title' => $request->input('sip_ref_forms_title'),
            'sip_ref_forms_activity_id' => $request->input('sip_ref_forms_activity_id')

            );

        $validator = Validator::make($input, [
            
            'sip_ref_forms_title' => 'required|string|max:255',
            'sip_ref_forms_activity_id' => 'required'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','addForm')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        Sip_ref_form::insert($input);
        
        return back()
                    ->with('status',1)
                    ->with('message','Success');

    }

    public function update_admin_form_proses($id,Request $request){
        
        $form = Sip_ref_form::find($id);

        if(!is_object($form))             
            return back()
                        ->with('type','updateForm')
                        ->with('message','Data not found')
                        ->with('id',$id)
                        ->with('status',0);

        $input = array(
            
            'sip_ref_forms_title' => $request->input('sip_ref_forms_title'),
            'sip_ref_forms_activity_id' => $request->input('sip_ref_forms_activity_id')

            );

        $validator = Validator::make($input, [
            
            'sip_ref_forms_title' => 'required|string|max:255',
            'sip_ref_forms_activity_id' => 'required'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','updateForm')
                        ->with('id',$id)
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $form->update($input);
        
        return back()
                    ->with('status',1)
                    ->with('message','Success');

    }

    public function delete_admin_form_proses($id,Request $request){
        
        $form = Sip_ref_form::find($id);

        if(!is_object($form))             
            return back()
                        ->with('type','deleteForm')
                        ->with('message','Data not found')
                        ->with('id',$id)
                        ->with('status',0);

        $input = array(
            
            'sip_ref_forms_status' => 'inactive'

            );

        $form->update($input);
        
        return back()
                    ->with('status',1)
                    ->with('message','Success');

    }

    public function index_activity()
    {   
        $activities = Sip_ref_activity::paginate(10);

        return view('admin.activity.view_activity_data',compact('activities'));
    }

    public function add_admin_activity_proses(Request $request){

        $input = array(
            
            'sip_ref_activities_name' => $request->input('sip_ref_activities_name')

            );;

        $validator = Validator::make($input, [
            
            'sip_ref_activities_name' => 'required|string|max:255'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','addActivity')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        Sip_ref_activity::insert($input);

        return back()
        			->with('status',1)
                    ->with('message','Success');

    }

	public function delete_admin_activity_proses($id, Request $request){
        
        $user = User::find($id);

        if(!is_object($user))             
        	return back()
                        ->with('type','deleteUser')
                        ->with('message','Data not found')
                        ->with('status',0);

        $input = [
            
            'user_status' => 'deleted'

        ];
        
        $user->update($input);

        return back()
        			->with('status',1)
                    ->with('message','Success');
	}

    public function generate_pelaporan_excel_proses($id,Request $request){

        $activities = Sip_ref_activity::where('sip_ref_activities_status','active')->get();
        $user = Auth::user();
        $from = $request->input('from');
        $to = $request->input('to');
        $dateSet = trim($request->input('from')) !== '' && trim($request->input('to')) !== '' ? ' from '.$request->input('from').' to '.$request->input('to') : '';
        $destinationPath = public_path().'/assets/'.$user->user_id.'/tmp';    
        $activity = Sip_ref_activity::find($id);

        $last = strtotime($from); 
        $next = strtotime($to);

        // clean directory
        $file = new Filesystem;
        $file->cleanDirectory($destinationPath);

        if(trim($from) !== '' && trim($to) !== '' && is_object($activity)){

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
            

                Excel::create('report_'.CustomHelper::pretty_url($activity->sip_ref_activities_name).'_'.date('Ymd_hms'), function($excel) use($activity,$dateSet) {

                // Set the spreadsheet title, creator, and description
                $excel->setTitle('report-'.CustomHelper::pretty_url($activity->sip_ref_activities_name).'-'.date('Ymd-h:m:s'));
                $excel->setCreator('Admin')->setCompany('SIP');
                $excel->setDescription('Report result for '.CustomHelper::pretty_url($activity->sip_ref_activities_name));

                    foreach($activity['forms'] as $form){  

                        $overallArray = [];                         
                        foreach($form->subs as $sub){
                            
                            if($sub->sip_ref_sub_forms_report_show){
                            
                                // title
                                $overallArray[] = ['Form '.$sub->sip_ref_sub_forms_title];
                                $titles = ['Params'];

                                foreach($sub->rows as $row){
                                    
                                    $titles[] = $row->sip_ref_rows_title;                                

                                }    
                                
                                $overallArray[] = $titles;

                                // data
                                $datas = [];
                                foreach($sub->columns as $col){
                                    $tmp_row = [$col->sip_ref_columns_title];
                                    
                                    foreach($sub->rows as $row){
                                        $tmp_row[] = $row['value'];
                                    }

                                    $overallArray[] = $tmp_row;
                                }
                                
                                $overallArray[] = [];
                                $overallArray[] = [];
                            }

                        }
                        
                        $excel->sheet(substr($sub->sip_ref_sub_forms_title,0,30), function($sheet) use ($overallArray,$form) {
                            
                            //$sheet->setBorder('A2:D'.count($overallArray), 'medium');

                            // header
    /*                        $sheet->row(2, function($row) {

                                $row->setBackground('#fff');

                            });*/

                            $sheet->fromModel($overallArray, null, 'A1', false, false);

                        });
                    }     
                                 
                })->store('xls', $destinationPath);       
                       

            $zipper = new \Chumper\Zipper\Zipper;

            $zipper->make(public_path().'/assets/'.$user->user_id.'/report-'.$dateSet.'.zip')->add(glob($destinationPath.'/*'))->close();

            if(File::exists(public_path().'/assets/'.$user->user_id.'/report-'.$dateSet.'.zip')){

                return response()->download(public_path().'/assets/'.$user->user_id.'/report-'.$dateSet.'.zip')->deleteFileAfterSend(true);

            }

        }

    }

    public function generate_pelaporan_excel_admin_proses($id,Request $request){

        $activities = Sip_ref_activity::where('sip_ref_activities_status','active')->get();
        $user = Auth::user();
        $from = $request->input('from');
        $to = $request->input('to');
        $dateSet = trim($request->input('from')) !== '' && trim($request->input('to')) !== '' ? ' from '.$request->input('from').' to '.$request->input('to') : '';
        $destinationPath = public_path().'/assets/'.$user->user_id.'/tmp';    
        $activity = Sip_ref_activity::find($id);

        $last = strtotime($from); 
        $next = strtotime($to);

        // clean directory
        $file = new Filesystem;
        $file->cleanDirectory($destinationPath);

        if(trim($from) !== '' && trim($to) !== '' && is_object($activity)){

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
            

                Excel::create('report_'.CustomHelper::pretty_url($activity->sip_ref_activities_name).'_'.date('Ymd_hms'), function($excel) use($activity,$dateSet) {

                // Set the spreadsheet title, creator, and description
                $excel->setTitle('report-'.CustomHelper::pretty_url($activity->sip_ref_activities_name).'-'.date('Ymd-h:m:s'));
                $excel->setCreator('Admin')->setCompany('SIP');
                $excel->setDescription('Report result for '.CustomHelper::pretty_url($activity->sip_ref_activities_name));

                    foreach($activity['forms'] as $form){  

                        $overallArray = [];                         
                        foreach($form->subs as $sub){
                            
                            if($sub->sip_ref_sub_forms_report_show){
                            
                                // title
                                $overallArray[] = ['Form '.$sub->sip_ref_sub_forms_title];
                                $titles = ['Params'];

                                foreach($sub->rows as $row){
                                    
                                    $titles[] = $row->sip_ref_rows_title;                                

                                }    
                                
                                $overallArray[] = $titles;

                                // data
                                $datas = [];
                                foreach($sub->columns as $col){
                                    $tmp_row = [$col->sip_ref_columns_title];
                                    
                                    foreach($sub->rows as $row){
                                        $tmp_row[] = $row['value'];
                                    }

                                    $overallArray[] = $tmp_row;
                                }
                                
                                $overallArray[] = [];
                                $overallArray[] = [];
                            }

                        }
                        
                        $excel->sheet(substr($sub->sip_ref_sub_forms_title,0,30), function($sheet) use ($overallArray,$form) {
                            
                            //$sheet->setBorder('A2:D'.count($overallArray), 'medium');

                            // header
    /*                        $sheet->row(2, function($row) {

                                $row->setBackground('#fff');

                            });*/

                            $sheet->fromModel($overallArray, null, 'A1', false, false);

                        });
                    }     
                                 
                })->store('xls', $destinationPath);       
                       

            $zipper = new \Chumper\Zipper\Zipper;

            $zipper->make(public_path().'/assets/'.$user->user_id.'/report-'.$dateSet.'.zip')->add(glob($destinationPath.'/*'))->close();

            if(File::exists(public_path().'/assets/'.$user->user_id.'/report-'.$dateSet.'.zip')){

                return response()->download(public_path().'/assets/'.$user->user_id.'/report-'.$dateSet.'.zip')->deleteFileAfterSend(true);

            }

        }

    }

    public function generate_pelaporan_json_admin_proses(Request $request){

        $activities = Sip_ref_activity::where('sip_ref_activities_status','active')->get();
        $user = Auth::user();
        $from = $request->input('from');
        $to = $request->input('to');
        $dateSet = trim($request->input('from')) !== '' && trim($request->input('to')) !== '' ? ' from '.$request->input('from').' to '.$request->input('to') : '';
        $destinationPath = 'assets/'.$user->user_id.'/tmp';    

        $last = strtotime($from); 
        $next = strtotime($to);

        // clean directory
        $file = new Filesystem;
        $file->cleanDirectory(public_path().'/'.$destinationPath);

        if(trim($from) !== '' && trim($to) !== ''){

            $submissions = Sip_trx_form_submission::where('created_at','>=',date('Y-m-d', $last))
                                                    ->where('created_at','<=',date('Y-m-d', $next))
                                                    ->get();

            $tmp_array = [];

            foreach($submissions as $submission){

                $tmp_value = [
                        
                        'submission_id' => $submission->sip_trx_form_submission_id, 
                        'submission_form_id' => $submission->sip_trx_form_submission_form_id, 
                        'submission_user_id' => $submission->sip_trx_form_submission_user_id

                        ];

                foreach($submission->values as $value){
                    
                    $arr = array( $value->sip_trx_form_values_code => $value->sip_trx_form_values_value_string );
                    
                    $tmp_value = array_merge($tmp_value,$arr);

                }

                $tmp_array[] = $tmp_value;

            }

            $tmp_array = [ 'data' => $tmp_array ];

            $file_name = 'generated_json_'.date('Ymd_hms').'.txt';

            Storage::put($file_name, json_encode($tmp_array));

            // user log
            $inputLog = array(

                'sip_trx_user_logs_user_id' => $user->user_id,
                'sip_trx_user_logs_type' => 'generate-submission-offline',
                'sip_trx_user_logs_desc' => 'Generating submission data from '.$from.' to '.$to

                );
            
            Sip_trx_user_log::create($inputLog);

            if(File::exists(storage_path().'/app/'.$file_name)){

                return response()->download(storage_path().'/app/'.$file_name)->deleteFileAfterSend(true);

            }

        }

    }

    public function generate_pelaporan_json_proses(Request $request){

        $activities = Sip_ref_activity::where('sip_ref_activities_status','active')->get();
        $user = Auth::user();
        $from = $request->input('from');
        $to = $request->input('to');
        $dateSet = trim($request->input('from')) !== '' && trim($request->input('to')) !== '' ? ' from '.$request->input('from').' to '.$request->input('to') : '';
        $destinationPath = 'assets/'.$user->user_id.'/tmp';    

        $last = strtotime($from); 
        $next = strtotime($to);

        // clean directory
        $file = new Filesystem;
        $file->cleanDirectory(public_path().'/'.$destinationPath);

        if(trim($from) !== '' && trim($to) !== ''){

            $submissions = Sip_trx_form_submission::where('sip_trx_form_submission_user_id',$user->user_id)
                                                    ->where('created_at','>=',date('Y-m-d', $last))
                                                    ->where('created_at','<=',date('Y-m-d', $next))
                                                    ->get();

            $tmp_array = [];

            foreach($submissions as $submission){

                $tmp_value = [
                        
                        'submission_id' => $submission->sip_trx_form_submission_id, 
                        'submission_form_id' => $submission->sip_trx_form_submission_form_id, 
                        'submission_user_id' => $submission->sip_trx_form_submission_user_id

                        ];

                foreach($submission->values as $value){
                    
                    $arr = array( $value->sip_trx_form_values_code => $value->sip_trx_form_values_value_string );
                    
                    $tmp_value = array_merge($tmp_value,$arr);

                }

                $tmp_array[] = $tmp_value;

            }

            $tmp_array = [ 'data' => $tmp_array ];

            $file_name = 'generated_json_'.date('Ymd_hms').'.txt';

            Storage::put($file_name, json_encode($tmp_array));

            // user log
            $inputLog = array(

                'sip_trx_user_logs_user_id' => $user->user_id,
                'sip_trx_user_logs_type' => 'generate-submission-offline',
                'sip_trx_user_logs_desc' => 'Generating submission data from '.$from.' to '.$to

                );
            
            Sip_trx_user_log::create($inputLog);

            if(File::exists(storage_path().'/app/'.$file_name)){

                return response()->download(storage_path().'/app/'.$file_name)->deleteFileAfterSend(true);

            }

        }

    }

}
