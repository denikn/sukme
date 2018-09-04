<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sip_trx_form_value extends Model
{
	protected $primaryKey = 'sip_trx_form_values_id';
	
    protected $fillable = [
        
        'sip_trx_form_values_value_string',
        'sip_trx_form_values_value_number',
        'sip_trx_form_values_code',
        'sip_trx_form_values_submission_id',
        'sip_trx_form_values_form_id',
        'sip_trx_form_values_sub_id'

    ];
}
