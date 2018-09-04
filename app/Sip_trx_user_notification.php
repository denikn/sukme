<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sip_trx_user_notification extends Model
{
	protected $primaryKey = 'sip_trx_user_notifications_id';

    protected $fillable = [
        
    	'sip_trx_user_notifications_user_id',
    	'sip_trx_user_notifications_foreign_id',
    	'sip_trx_user_notifications_text',
    	'sip_trx_user_notifications_type',
    	'sip_trx_user_notifications_status'

    ];
}
