<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sip_ref_column extends Model
{
	protected $primaryKey = 'sip_ref_columns_id';
    public $timestamps = true;
    protected $fillable = [
        
        'sip_ref_columns_title',
        'sip_ref_columns_sub_id',
        'sip_ref_columns_group_id',
        'sip_ref_columns_parent_id',
        'sip_ref_columns_parent_type',
        'sip_ref_columns_show_title',
        'sip_ref_columns_val_type'

    ];

    public function group(){
    	
    	return $this->belongsTo('App\Sip_ref_row','sip_ref_columns_group_id','sip_ref_rows_id');

    }
    
    public function parent(){
        
        return $this->belongsTo('App\Sip_ref_column','sip_ref_columns_parent_id','sip_ref_columns_id');

    }

    public function children()
    {
        return $this->hasMany('App\Sip_ref_column','sip_ref_columns_parent_id','sip_ref_columns_id');
    }

}
