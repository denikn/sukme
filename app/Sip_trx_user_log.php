<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sip_trx_user_log extends Model
{
	protected $primaryKey = 'sip_trx_user_logs_id';

    protected $fillable = [
        
    	'sip_trx_user_logs_id',
    	'sip_trx_user_logs_user_id',
    	'sip_trx_user_logs_foreign_id',
    	'sip_trx_user_logs_to_id',
    	'sip_trx_user_logs_type',
    	'sip_trx_user_logs_desc'

    ];

    public function user(){
    	
    	return $this->belongsTo('App\User','sip_trx_user_logs_user_id','user_id');

    }

}
