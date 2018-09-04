<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sip_ref_sub_form extends Model
{
    
    protected $primaryKey = 'sip_ref_sub_forms_id';

    protected $fillable = [
        
        'sip_ref_sub_forms_title',
        'sip_ref_sub_forms_form_id',
        'sip_ref_sub_forms_send_type',
        'sip_ref_sub_forms_show_type',
        'sip_ref_sub_forms_status',
        'sip_ref_sub_forms_report_show'

    ];
    
    public function form(){
    	
    	return $this->belongsTo('App\Sip_ref_form','sip_ref_activities_id','sip_ref_sub_forms_form_id');

    }
    
    public function columns()
    {
        return $this->hasMany('App\Sip_ref_column','sip_ref_columns_sub_id','sip_ref_sub_forms_id');
    }
    
    public function rows()
    {
        return $this->hasMany('App\Sip_ref_row','sip_ref_rows_sub_id','sip_ref_sub_forms_id');
    }

    public function values()
    {
        return $this->hasMany('App\Sip_trx_form_value','sip_trx_form_values_sub_id','sip_ref_sub_forms_id');
    }

}
