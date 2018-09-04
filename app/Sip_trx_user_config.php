<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sip_trx_user_config extends Model
{

	protected $primaryKey = 'sip_trx_user_configs_id';

    protected $fillable = [
        
    	'sip_trx_user_configs_trf_data_type',
    	'sip_trx_user_configs_user_id',
    	'sip_trx_user_configs_trf_type'

    ];

    public function user(){
    	
    	return $this->belongsTo('App\User','sip_trx_user_configs_user_id','user_id');

    }

}
