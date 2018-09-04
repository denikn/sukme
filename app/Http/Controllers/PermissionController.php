<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Sip_ref_permission;

class PermissionController extends Controller
{

    public function add_admin_permission_proses(Request $request){

        $input = array(
            
            'sip_ref_permissions_name' => $request->input('sip_ref_permissions_name'),
            'sip_ref_permissions_code' => strtoupper(str_replace(' ', '_', $request->input('sip_ref_permissions_name')))

            );

        $validator = Validator::make($input, [
            
            'sip_ref_permissions_name' => 'required|string|max:255'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','addPermission')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        Sip_ref_permission::insert($input);

        return back()
        			->with('status',1)
                    ->with('message','Success');

    }

}
