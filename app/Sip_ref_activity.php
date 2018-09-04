<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sip_ref_activity extends Model
{
	
	protected $primaryKey = 'sip_ref_activities_id';

    protected $fillable = [
        'sip_ref_activities_name','sip_ref_activities_status'
    ];

    public function forms()
    {
        return $this->hasMany('App\Sip_ref_form','sip_ref_forms_activity_id','sip_ref_activities_id');
    }
    
}
