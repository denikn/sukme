<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sip_trx_user_permission extends Model
{

	protected $primaryKey = 'sip_trx_user_permissions_id';
	
    protected $fillable = [
        
        'sip_trx_user_permissions_user_id',
        'sip_trx_user_permissions_permission_id'

    ];

    public function permission()
    {
        return $this->hasOne('App\Sip_ref_permission','sip_ref_permissions_id','sip_trx_user_permissions_permission_id');
    }

}
