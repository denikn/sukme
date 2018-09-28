<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Sip_ref_activity;
use App\Sip_ref_form;
use App\Sip_ref_sub_form;
use App\Sip_ref_column;
use App\Sip_ref_row;
use App\Sip_trx_row_value;
use App\Sip_trx_form_value;
use App\Sip_trx_form_submission;
use App\Sip_trx_user_notification;

class ApiController extends Controller
{
    
    public function formValueApi($id,$form,$submission)
    {   
                
        $subs = Sip_ref_form::find($form)->subs;

        foreach($subs as $sub){
            
            // get row
            $tmpRows = $sub->rows()->where('sip_ref_rows_type_row','row')->get();

            foreach($tmpRows as $row){
                
                //get row columns
                $tmpCodes = $row->codes;
                
                foreach($tmpCodes as $code){

                    $code['value'] = Sip_trx_form_value::where('sip_trx_form_values_code',$code->sip_trx_row_values_code)->where('sip_trx_form_values_submission_id',$submission)->first();

                }   
                                             
                $row['values'] = $tmpCodes;
                
                unset($row['codes']);

            }

            $sub['rows'] = $tmpRows; 

        }

        return $subs;
    }

    public function paramsIndexApi($id,$sub)
    {   
                
        $subs = Sip_ref_form::find($sub)->subs;

        foreach($subs as $sub){
            
            //groups
            $groups = $sub->rows()->where('sip_ref_rows_type_row','group')->get();

            foreach($groups as $group){
                
                //get columns
                $groupcolumns = $group->groupcolumns()->where('sip_ref_columns_parent_type','parent')->get();

                foreach($groupcolumns as $gc){

                    $gc->children;

                }

                //get rows
                $grouprows = $group->grouprows()->where('sip_ref_rows_type_parent','parent')->with('codes')->get();

                // get rows children
                foreach($grouprows as $gr){
                    
                    foreach($gr->codes as $code){

                        $column = $code->column;

                        unset($code['column']);

                        if(!count($column->children)) $code['column'] = $code->column;

                    }

                    foreach($gr->children as $children){

                        foreach($children->codes as $code){
                            
                            $column = $code->column;

                            unset($code['column']);

                            if(!count($column->children)) $code['column'] = $code->column;

                        }

                    }

                }

                $group['grouprows'] = $grouprows;
                $group['groupcolumns'] = $groupcolumns;

            }

            $sub['tables'] = $groups;
        }

        return $subs;
    }

    public function activityListApi()
    {   
        return Sip_ref_activity::all();
    }

    public function formListApi($id)
    {   
        
        return Sip_ref_activity::find($id)->forms;
    }

    public function subformIndexApi($id,$sub)
    {   
        
        return Sip_ref_form::find($id)->subs;

    }

    public function paramsStoreApi($id, Request $request)
    {   

        // check form
        $form = Sip_ref_form::find($id);
        $user = User::find($request->input('by'));
        $site_config = Sip_trx_site_config::first();

        if(!is_object($form) || !is_object($user)){
            return array('status' => false, 'code' => 500, 'message' => 'Data not found');
        }

        // input submission
        $input = array(
            
            'sip_trx_form_submission_user_id' => $request->input('by'),
            'sip_trx_form_submission_form_id' => $id
            
            );

        $submission = Sip_trx_form_submission::create($input);

        $tmp_array = [];
        $tmp_value = [
                
                'submission_id' => $submission->sip_trx_form_submission_id, 
                'submission_form_id' => $submission->sip_trx_form_submission_form_id, 
                'submission_user_id' => $submission->sip_trx_form_submission_user_id

                ];

        foreach($request->all() as $key => $req){

            if($req !== 'by'){

                $input = array(
                    'sip_trx_form_values_value_string' => $req,
                    'sip_trx_form_values_code' => $key,
                    'sip_trx_form_values_submission_id' => $submission->sip_trx_form_submission_id,
                    'sip_trx_form_values_form_id' => $id
                    );

                $value = Sip_trx_form_value::create($input);                 
                
                $arr = array( $value->sip_trx_form_values_code => $value->sip_trx_form_values_value_string );
                $tmp_value = array_merge($tmp_value,$arr);

            }

        }
        
        $tmp_array[] = $tmp_value; 

        // user log
        $inputLog = array(

            'sip_trx_user_logs_user_id' => $request->input('by'),
            'sip_trx_user_logs_type' => 'new-submission',
            'sip_trx_user_logs_foreign_id' => $submission->sip_trx_form_submission_id,
            'sip_trx_user_logs_desc' => 'Inputting submission data'

            );
        
        Sip_trx_user_log::create($inputLog);

        if(is_object($site_config) 
                && $site_config->sip_trx_site_configs_trf_type == 'online' 
                && $site_config->sip_trx_site_configs_trf_data_type == 'single'){

            //store api
            $client = new \GuzzleHttp\Client();
            
            $tmp_array = [ 'data' => $tmp_array ];

            $headers = [
                
                'Authorization' => $site_config->sip_trx_site_configs_key_sisdinkes

            ];

            $response = $client->request("POST", $url, [ 'body'=> $tmp_array]);
            $response = $client->send($response, [ 'headers' => $headers ]);

            if( true == false ){

                // user notification
                $input = array(

                    'sip_trx_user_notifications_user_id' => $request->input('by'),
                    'sip_trx_user_notifications_foreign_id' => $submission->sip_trx_form_submission_id,
                    'sip_trx_user_notifications_text' => 'Your submission data for '.$form->sip_ref_form_title.' has been sent to Sisdinkes',
                    'sip_trx_user_notifications_type' => 'new-submission-single-online'

                    );
                
                Sip_trx_user_notification::create($input); 

            }

        }

        return array('status' => true, 'code' => 200, 'message' => 'Success');
    }

    public function paramsStoreApiBulk(Request $request)
    {   

        // get data
        $datas = $request->input('data');

        // submission
        $submissions = [];

        foreach($datas as $data){
    
            // input submission
            $input = array(
                
                'sip_trx_form_submission_user_id' => $data['submission_user_id'],
                'sip_trx_form_submission_form_id' => $data['submission_form_id']
                
                );

            $submission = Sip_trx_form_submission::create($input);

            if(is_object($submission)){
                
                foreach($data as $key => $req){

                    if($req !== 'by' && !strpos($req,'submission')){

                        $input = array(

                            'sip_trx_form_values_value_string' => $req,
                            'sip_trx_form_values_code' => $key,
                            'sip_trx_form_values_submission_id' => $submission->sip_trx_form_submission_id,
                            'sip_trx_form_values_form_id' => $data['submission_form_id']

                            );

                        $value = Sip_trx_form_value::create($input);   

                    }

                } 

                $submissions[] = [ 'submission_id' => $data['submission_id'] ];
            
            }

        }

        return array('status' => true, 'data' => $submissions,'code' => 200, 'message' => 'Success');
    }

}
