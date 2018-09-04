<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sip_trx_form_submission extends Model
{

	protected $primaryKey = 'sip_trx_form_submission_id';
	
    protected $fillable = [
        
        'sip_trx_form_submission_id',
        'sip_trx_form_submission_user_id',
        'sip_trx_form_submission_form_id'

    ];
    
    public function subs()
    {
        return $this->hasMany('App\Sip_ref_sub_form','sip_ref_sub_forms_form_id','sip_ref_forms_id');
    }
    
    public function values()
    {
        return $this->hasMany('App\Sip_trx_form_value','sip_trx_form_values_submission_id','sip_trx_form_submission_id');
    }

    public function form(){
        
        return $this->belongsTo('App\Sip_ref_form','sip_trx_form_submission_form_id','sip_ref_forms_id');

    }

    public function user(){
        
        return $this->belongsTo('App\User','sip_trx_form_submission_user_id','user_id');

    }
}
