<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\File;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'email','user_status', 'password','user_description','user_phone','user_address','user_type','user_img_profile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function statusClass($a){

        $class = 'success';
        switch ($a) {
            case 'inctive':
               $class = 'warning';
                break;
            case 'banned':
               $class = 'danger';
                break;
            case 'deleted':
               $class = 'danger';
                break;
        }

        return $class;
    }

    public static $columns = array(

        'user_name',
        'email',
        'user_description',
        'user_phone',
        'user_address',
        'user_status',
        'user_type'

        );

    // aksesor
    public function getUserImgProfileAttribute($value)
    {   

        $path = 'https://placeholdit.co//i/50x50?text='.strtoupper(substr($this->user_name, 0, 2));

        if(trim($value) !== '') $path = asset('/assets/'.$this->user_id.'/profile/'.$value);

        return $path;

    }

    /**
    *
    * override method create
    *
    **/

    public static function create(array $data) {

        /**
        *
        * Create folder for user
        * 
        **/

        $parent = parent::create($data);

        $permalink = $parent->user_id;
        
        $path = public_path().'/assets/' . $permalink;

        if(!File::exists($path)){
            File::makeDirectory($path);

            // create folders
            if(!File::exists($path.'/profile')){
                File::makeDirectory($path.'/profile');
            }

            // create folders
            if(!File::exists($path.'/tmp')){
                File::makeDirectory($path.'/tmp');
            }
            
            // create folders
            if(!File::exists($path.'/attachments')){
                File::makeDirectory($path.'/attachments');
            }

            // create folders
            if(!File::exists($path.'/media')){
                File::makeDirectory($path.'/media');
                File::makeDirectory($path.'/media/thumb');
            }
        }

        return $parent;

    }

    public function permissions()
    {
        return $this->hasMany('App\Sip_trx_user_permission','sip_trx_user_permissions_user_id','user_id');
    }

    public function config()
    {
        return $this->hasOne('App\Sip_trx_user_config','sip_trx_user_configs_user_id','user_id');
    }

}
