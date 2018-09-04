<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use Chumper\Zipper\Zipper;

use App\User;
use App\Sip_trx_user_permission;
use App\Sip_trx_user_config;

class UserController extends Controller
{

	public function add_admin_user_proses(Request $request){
        
        $input = [
            
            'user_name' => $request->input('user_name'),
            'email' => $request->input('email'),
            'user_status' => 'active',
            'user_type' => 'user',
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation')

        ];

        $validator = Validator::make($input, [
            
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','addUser')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $input['password'] = bcrypt($request->input('password'));
        unset($input['password_confirmation']);

        $user = User::create($input);

        return back()
        			->with('status',1)
                    ->with('message','Success');
	}

	public function add_admin_permission_proses($id,Request $request){
        
        $input = [
            
            'sip_trx_user_permissions_permission_id' => $request->input('sip_trx_user_permissions_permission_id'),
            'sip_trx_user_permissions_user_id' => $id
        ];

        $validator = Validator::make($input, [
            
            'sip_trx_user_permissions_permission_id' => 'required'

        ]);
        
        // check user permission exist
        $check = Sip_trx_user_permission::where('sip_trx_user_permissions_permission_id',$request->input('sip_trx_user_permissions_permission_id'))
        		->where('sip_trx_user_permissions_user_id',$id)->first();

        if ($validator->fails() || is_object($check)) {

            return back()
                        ->withErrors($validator)
                        ->with('type','addPermission')
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        Sip_trx_user_permission::create($input);

        return back()
        			->with('status',1)
                    ->with('message','Success');
	}

	public function delete_admin_permission_proses($id,$permission, Request $request){
        
        $data = Sip_trx_user_permission::where('sip_trx_user_permissions_user_id',$id)
        							->where('sip_trx_user_permissions_id',$permission)
        							->first();

        if(!is_object($data))             
        	return back()
                        ->with('type','deletePermission')
                        ->with('message','Data not found')
                        ->with('status',0);

        $data->delete();

        return back()
        			->with('status',1)
        			->with('type','deletePermission')
                    ->with('message','Success');
	}

	public function update_admin_user_proses($id, Request $request){
        
        $user = User::find($id);

        if(!is_object($user))             
        	return back()
                        ->with('type','updateUser')
                        ->with('message','Data not found')
                        ->with('status',0);

        $input = [
            
            'user_name' => $request->input('user_name'),
            'user_status' => $request->input('user_status'),
	        'user_description' => $request->input('user_description'),
	        'user_phone' => $request->input('user_phone'),
	        'user_address' => $request->input('user_address')

        ];

        $validator = Validator::make($input, [
            
            'user_name' => 'required|string|max:255'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','updateUser')
                        ->with('id',$id)
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $user->update($input);

        return back()
        			->with('status',1)
                    ->with('message','Success');
	}

	public function update_admin_email_proses($id, Request $request){
        
        $user = User::find($id);

        if(!is_object($user))             
        	return back()
                        ->with('type','updateUser')
                        ->with('message','Data not found')
                        ->with('status',0);

        $input = [
            
            'email' => $request->input('email')

        ];

        $validator = Validator::make($input, [
            
            'email' => 'required|string|email|max:255|unique:users'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','updateEmailUser')
                        ->with('id',$id)
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $user->update($input);

        return back()
        			->with('status',1)
                    ->with('message','Success');
	}


	public function update_admin_password_proses($id, Request $request){
        
        $user = User::find($id);

        if(!is_object($user))             
        	return back()
                        ->with('type','updateUser')
                        ->with('message','Data not found')
                        ->with('status',0);

        $input = [
            
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation')

        ];

        $validator = Validator::make($input, [
            
            'password' => 'required|string|min:6|confirmed'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','updatePasswordUser')
                        ->with('id',$id)
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }
        
        $input['password'] = bcrypt($request->input('password'));
        unset($input['password_confirmation']);

        $user->update($input);

        return back()
        			->with('status',1)
                    ->with('message','Success');
	}

    public function update_member_user_proses($id, Request $request){
        
        $user = User::find(Crypt::decryptString($id));

        $file = $request->file('user_img_profile');
        $destinationPath = public_path().'/assets/'.$user->user_id.'/profile/';        

        if(!is_object($user))             
            return back()
                        ->with('type','updateUser')
                        ->with('message','Data not found')
                        ->with('status',0);

        $input = [
            
            'user_name' => $request->input('user_name'),
            'user_description' => $request->input('user_description'),
            'user_phone' => $request->input('user_phone'),
            'user_address' => $request->input('user_address')

        ];

        $validator = Validator::make($input, [
            
            'user_name' => 'required|string|max:255'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','updateUser')
                        ->with('id',$id)
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $user->update($input);

        if($request->hasFile('user_img_profile')){

            if(!File::exists(public_path().'/assets/'.$user->user_id)){

                File::makeDirectory(public_path().'/assets/'.$user->user_id);   

            }
            
            if(!File::exists($destinationPath)){

                File::makeDirectory($destinationPath);    

            }

            $input = array(

                'user_img_profile' => $request->file('user_img_profile')

                );

            $rules = array(

                'user_img_profile' => 'required|mimes:jpeg,png,jpg|max:50480'

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

            $filename = CustomHelper::pretty_url(str_random(6).'_'.$file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();;

            $file->move($destinationPath,$filename);

            $img = Image::make($destinationPath.''.$filename);

            //set medium
            $img->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.''.$filename);

            $input = array(

                'user_img_profile' => $filename

                );

            //delete old picture that different from the default picture
            if(File::exists($destinationPath.''.$user->user_img_profile)){

                File::delete($destinationPath.''.$user->user_img_profile);

            }

            //update photo
            $user->update($input);

        }

        return back()
                    ->with('status',1)
                    ->with('message','Success');
    }

    public function update_member_email_proses($id, Request $request){
        
        $user = User::find(Crypt::decryptString($id));

        if(!is_object($user))             
            return back()
                        ->with('type','updateUser')
                        ->with('message','Data not found')
                        ->with('status',0);

        $input = [
            
            'email' => $request->input('email')

        ];

        $validator = Validator::make($input, [
            
            'email' => 'required|string|email|max:255|unique:users'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','updateEmailUser')
                        ->with('id',$id)
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $user->update($input);

        return back()
                    ->with('status',1)
                    ->with('message','Success');
    }


    public function update_member_password_proses($id, Request $request){
        
        $user = User::find(Crypt::decryptString($id));

        if(!is_object($user))             
            return back()
                        ->with('type','updateUser')
                        ->with('message','Data not found')
                        ->with('status',0);

        $input = [
            
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation')

        ];

        $validator = Validator::make($input, [
            
            'password' => 'required|string|min:6|confirmed'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','updatePasswordUser')
                        ->with('id',$id)
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }
        
        $input['password'] = bcrypt($request->input('password'));
        unset($input['password_confirmation']);

        $user->update($input);

        return back()
                    ->with('status',1)
                    ->with('message','Success');
    }

    public function update_member_setting_proses($id, Request $request){
        
        $user = User::find(Crypt::decryptString($id));

        if(!is_object($user))             
            return back()
                        ->with('type','updateUser')
                        ->with('message','Data not found')
                        ->with('status',0);

        $input = [
            
            'sip_trx_user_configs_trf_data_type' => $request->input('sip_trx_user_configs_trf_data_type'),
            'sip_trx_user_configs_trf_type' => $request->input('sip_trx_user_configs_trf_type')

        ];

        $validator = Validator::make($input, [
            
            'sip_trx_user_configs_trf_data_type' => 'required|in:bulk,single'

        ]);
        
        if ($validator->fails()) {

            return back()
                        ->withErrors($validator)
                        ->with('type','updateEmailUser')
                        ->with('id',$id)
                        ->with('message','Please check the input form')
                        ->with('status',0)
                        ->withInput();
        }

        $user->config()->update($input);

        return back()
                    ->with('status',1)
                    ->with('message','Success');
    }

    public function update_photo_proses($id, Request $request){

        $id = Crypt::decrypt($id);
        $user = Tbl_user::find($id);
        $file = $request->file('user_img_profile');
        $destinationPath = public_path().'/assets/'.$user->user_id.'/profile/';    

        $input = array(

            'user_img_profile' => $request->file('user_img_profile')

            );

        $rules = array(

            'user_img_profile' => 'required|mimes:jpeg,png,jpg|max:50480'

            );
       

        $validator = Validator::make($input,$rules);       

        if($validator->passes())
        {
            
            if(!File::exists(public_path().'/assets/'.$user->user_id)){

                File::makeDirectory(public_path().'/assets/'.$user->user_id);   

            }
            
            if(!File::exists($destinationPath)){

                File::makeDirectory($destinationPath);    

            }

            if($request->hasFile('user_img_profile'))
            {

                $filename = CustomHelper::pretty_url(str_random(6).'_'.$file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();;

                $file->move($destinationPath,$filename);

                $img = Image::make($destinationPath.''.$filename);

                //set medium
                $img->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.''.$filename);

                $input = array(

                    'user_img_profile' => $filename

                    );

                //delete old picture that different from the default picture
                if(File::exists($destinationPath.''.$user->user_img_profile)){

                    File::delete($destinationPath.''.$user->user_img_profile);

                }

                //update photo
                $user->update($input);

                return back()
                            ->with('status',1)
                            ->with('message','Success');

            }

        }

        return back()
                    ->withErrors($validator)
                    ->with('type','updateEmailUser')
                    ->with('id',$id)
                    ->with('message','Please check the input form')
                    ->with('status',0)
                    ->withInput();
    }

	public function delete_admin_user_proses($id, Request $request){
        
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
}
