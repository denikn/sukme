<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;
use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Sip_ref_permission;
use App\Sip_trx_site_config;
use App\Sip_ref_activity;
use App\Sip_trx_form_submission;
use App\Sip_ref_form;
use App\Sip_trx_user_log;

class AdminController extends Controller
{
    
/*    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    */
    public function index()
    {

        $activities = Sip_trx_user_log::paginate(20);

        $stats = array(
            
            'users' => User::where('user_status','active')->count(),
            'activities' => Sip_ref_activity::where('sip_ref_activities_status','active')->count(),
            'submissions' => Sip_trx_form_submission::count(),
            'forms' => Sip_ref_form::where('sip_ref_forms_status','active')->count()

            );

        return view('admin.main',compact('stats','activities'));
    }

    public function view_profile()
    {
        return view('admin.profile');
    }

    public function index_config()
    {

        // chec user config
        $config = Sip_trx_site_config::first();

        if(!is_object($config)){

            $input = array(
                
                'sip_trx_site_configs_title' => 'SIP',
                'sip_trx_site_configs_icon' => '#',
                'sip_trx_site_configs_logo' => '#',
                'sip_trx_site_configs_description' => 'No Description',
                'sip_trx_site_configs_address' => 'No Address',
                'sip_trx_site_configs_key_sisdinkes'  => 'No Key',

                );

            $config = Sip_trx_site_config::create($input);

        }

        return view('admin.config',compact('config'));
    }

    public function index_puskesmas()
    {

        // chec user config
        $config = Sip_trx_site_config::first();

        if(!is_object($config)){

            $input = array(
                
                'sip_trx_site_configs_title' => 'SIP',
                'sip_trx_site_configs_icon' => '#',
                'sip_trx_site_configs_logo' => '#',
                'sip_trx_site_configs_description' => 'No Description',
                'sip_trx_site_configs_address' => 'No Address',
                'sip_trx_site_configs_key_sisdinkes'  => 'No Key',

                );

            $config = Sip_trx_site_config::create($input);

        }

        return view('admin.config-puskesmas',compact('config'));
    }

    public function update_meta_proses(Request $request)
    {

        // chec user config
        $config = Sip_trx_site_config::first();

        if(!is_object($config)){

            $input = array(
                
                'sip_trx_site_configs_title' => 'SIP',
                'sip_trx_site_configs_icon' => '#',
                'sip_trx_site_configs_logo' => '#',
                'sip_trx_site_configs_description' => 'No Description',
                'sip_trx_site_configs_address' => 'No Address',
                'sip_trx_site_configs_key_sisdinkes'  => 'No Key',

                );

            $config = Sip_trx_site_config::create($input);

        }

        $input = array(
            
            'sip_trx_site_configs_title' => $request->input('sip_trx_site_configs_title'),
            'sip_trx_site_configs_icon' => '#',
            'sip_trx_site_configs_logo' => '#',
            'sip_trx_site_configs_description' => $request->input('sip_trx_site_configs_description'),
            'sip_trx_site_configs_address' => $request->input('sip_trx_site_configs_address'),
            'sip_trx_site_configs_key_sisdinkes'  => $request->input('sip_trx_site_configs_key_sisdinkes'),

            );

        $validator = Validator::make($input, [
            
            'sip_trx_site_configs_title' => 'required|string|max:255'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','updateConfig')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $config->update($input);

        return back()
                    ->with('status',1)
                    ->with('message','Success');
    }

    public function update_setting_proses(Request $request)
    {

        // chec user config
        $config = Sip_trx_site_config::first();

        if(!is_object($config)){

            $input = array(
                
                'sip_trx_site_configs_title' => 'SIP',
                'sip_trx_site_configs_icon' => '#',
                'sip_trx_site_configs_logo' => '#',
                'sip_trx_site_configs_description' => 'No Description',
                'sip_trx_site_configs_address' => 'No Address',
                'sip_trx_site_configs_key_sisdinkes'  => 'No Key',

                );

            $config = Sip_trx_site_config::create($input);

        }

        $input = array(
            
            'sip_trx_site_configs_trf_type' => $request->input('sip_trx_site_configs_trf_type'),
            'sip_trx_site_configs_trf_data_type' => $request->input('sip_trx_site_configs_trf_data_type')

            );

        $validator = Validator::make($input, [
            
            'sip_trx_site_configs_trf_type' => 'required',
            'sip_trx_site_configs_trf_data_type' => 'required'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','updateConfig')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $config->update($input);

        return back()
                    ->with('status',1)
                    ->with('message','Success');
    }

    public function update_puskesmas_proses(Request $request)
    {

        // chec user config
        $config = Sip_trx_site_config::first();
        $file = $request->file('sip_trx_site_configs_logo');
        $destinationPath = public_path().'/config/';        

        if(!is_object($config)){

            $input = array(
                
                'sip_trx_site_configs_title' => 'SIP',
                'sip_trx_site_configs_icon' => '#',
                'sip_trx_site_configs_logo' => '#',
                'sip_trx_site_configs_description' => 'No Description',
                'sip_trx_site_configs_address' => 'No Address',
                'sip_trx_site_configs_key_sisdinkes'  => 'No Key',

                );

            $config = Sip_trx_site_config::create($input);

        }

        $input = array(
            
            'sip_trx_site_configs_puskemas_name' => $request->input('sip_trx_site_configs_puskemas_name'),
            'sip_trx_site_configs_puskemas_address' => $request->input('sip_trx_site_configs_puskemas_address'),
            'sip_trx_site_configs_puskemas_phone' => $request->input('sip_trx_site_configs_puskemas_phone'),
            'sip_trx_site_configs_puskemas_code' => $request->input('sip_trx_site_configs_puskemas_code')

            );

        $validator = Validator::make($input, [

            'sip_trx_site_configs_puskemas_name' => 'required|string|max:255',
            'sip_trx_site_configs_puskemas_address' => 'required|string|max:255',
            'sip_trx_site_configs_puskemas_phone' => 'required|string|max:255',
            'sip_trx_site_configs_puskemas_code' => 'required|string|max:255'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','updateConfig')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $config->update($input);

        if($request->hasFile('sip_trx_site_configs_logo')){

            if(!File::exists(public_path().'/config')){

                File::makeDirectory(public_path().'/config');   

            }

            $input = array(

                'sip_trx_site_configs_logo' => $request->file('sip_trx_site_configs_logo')

                );

            $rules = array(

                'sip_trx_site_configs_logo' => 'required|mimes:jpeg,png,jpg|max:50480'

                );

            $validator = Validator::make($input,$rules); 

            if ($validator->fails()) {

                return back()
                            ->withErrors($validator)
                            ->with('type','updateUser')
                            ->with('id',$id)
                            ->with('message','Please check the input form')
                            ->with('status',0)
                            ->withInput();
            }

            $filename = CustomHelper::pretty_url(str_random(6).'_'.$file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();

            $file->move($destinationPath,$filename);

            $img = Image::make($destinationPath.''.$filename);

            //set medium
            $img->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.''.$filename);

            $input = array(

                'sip_trx_site_configs_logo' => $filename

                );

            //delete old picture that different from the default picture
            if(File::exists($destinationPath.''.$config->sip_trx_site_configs_logo)){

                File::delete($destinationPath.''.$config->sip_trx_site_configs_logo);

            }

            //update photo
            $config->update($input);

        }

        return back()
                    ->with('status',1)
                    ->with('message','Success');
    }

    public function index_generate_activity(Request $request)
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

        return view('admin.report.index_send_report',compact('activities','user','logs'));
    
    }

    public function index_user(Request $request){
		
		$order = trim($request->input('orderBy')) !== '' ? $request->input('orderBy') : 'created_at';
		$orderDirection = $request->input('orderDirection') == 'true' ? 'ASC' : 'DESC';
		$paginate = trim($request->input('total')) !== '' ? $request->input('total') : 10;

    	$users = User::where('user_type','user');
		
		if(trim($request->input('q')) !== ''){

            $users->where(function($query) use ($request)
            {

            	foreach(User::$columns as $c){

                	$query->orWhere($c, 'LIKE', '%'.$request->input('q').'%');

            	}

            });

		}
		
		$users = $users->orderBy($order,$orderDirection)->paginate($paginate);	
		$permissions = Sip_ref_permission::all();

		return view('admin.user.view_user_data',compact('users','request','permissions'));
    }

    public function index_permission(Request $request){
		
		$order = trim($request->input('orderBy')) !== '' ? $request->input('orderBy') : 'created_at';
		$orderDirection = $request->input('orderDirection') == 'true' ? 'ASC' : 'DESC';
		$paginate = trim($request->input('total')) !== '' ? $request->input('total') : 10;

    	$datas = new Sip_ref_permission();
		
		if(trim($request->input('q')) !== ''){

            $users->where(function($query) use ($request)
            {

            	foreach(Sip_ref_permission::$columns as $c){

                	$query->orWhere($c, 'LIKE', '%'.$request->input('q').'%');

            	}

            });

		}
		
		$datas = $datas->orderBy($order,$orderDirection)->paginate($paginate);	

		return view('admin.permission.view_permission_data',compact('datas','request'));
    }

}
