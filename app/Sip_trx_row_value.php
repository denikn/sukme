<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sip_trx_row_value extends Model
{
	protected $primaryKey = 'sip_trx_row_values_id';
	
    protected $fillable = [
        
        'sip_trx_row_values_code',
        'sip_trx_row_values_row_id',
        'sip_trx_row_values_column_id'

    ];

    public function column(){
        
        return $this->belongsTo('App\Sip_ref_column','sip_trx_row_values_column_id','sip_ref_columns_id');

    }
}
