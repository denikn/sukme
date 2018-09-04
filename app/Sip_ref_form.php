<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sip_ref_form extends Model
{
	
	protected $primaryKey = 'sip_ref_forms_id';

    protected $fillable = [
        
        'sip_ref_forms_title',
        'sip_ref_forms_activity_id',
        'sip_ref_forms_status',
        'created_at',
        'updated_at'

    ];

    public function activity(){
    	
    	return $this->belongsTo('App\Sip_ref_activity','sip_ref_forms_activity_id','sip_ref_activities_id');

    }

    public function submissions()
    {
        return $this->hasMany('App\Sip_trx_form_submission','sip_trx_form_submission_form_id','sip_ref_forms_id');
    }

    public function subs()
    {
        return $this->hasMany('App\Sip_ref_sub_form','sip_ref_sub_forms_form_id','sip_ref_forms_id');
    }

    public function values()
    {
        return $this->hasMany('App\Sip_trx_form_value','sip_trx_form_values_form_id','sip_ref_forms_id');
    }

}
