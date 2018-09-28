<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Log;

use App\Sip_ref_permission;
use App\Sip_trx_user_permission;
use App\User;

class PermissionController extends Controller
{

    public function add_admin_permission_proses(Request $request){

        $input = array(
            
            'sip_ref_permissions_name' => $request->input('sip_ref_permissions_name'),
            'sip_ref_permissions_code' => strtoupper(str_replace(' ', '_', $request->input('sip_ref_permissions_name')))

            );

        $validator = Validator::make($input, [
            
            'sip_ref_permissions_name' => 'required|string|max:255',
            'sip_ref_permissions_code' => 'unique:sip_ref_permissions,sip_ref_permissions_code'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','addPermission')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
                        
        }

        $permission = Sip_ref_permission::insertGetId($input);

        if(trim($request->input('is_apply_to_all')) !== ''){

            $users = User::all();

            foreach($users as $user){
                
                $input = [
                    
                    'sip_trx_user_permissions_permission_id' => $permission,
                    'sip_trx_user_permissions_user_id' => $user->user_id

                ];
                
                // check user permission exist
                $check = Sip_trx_user_permission::where('sip_trx_user_permissions_permission_id',$permission)
                        ->where('sip_trx_user_permissions_user_id',$user->user_id)->first();

                if (!is_object($check)) {
                    
                    Sip_trx_user_permission::create($input);

                }   
                             
            }            

        }

        return back()
        			->with('status',1)
                    ->with('message','Success');

    }

}
