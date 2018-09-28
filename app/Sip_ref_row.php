<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use App\Sip_trx_form_value;
use App\Sip_trx_form_submission;

class Sip_ref_row extends Model
{
	protected $primaryKey = 'sip_ref_rows_id';    
    protected $appends = array('atc_value');

    protected $fillable = [
        
        'sip_ref_rows_title',
        'sip_ref_rows_type_row',
        'sip_ref_rows_type_parent',
        'sip_ref_rows_sub_id',
        'sip_ref_rows_group_id',
        'sip_ref_rows_parent_id',
        'sip_ref_rows_show_title',
        'sip_ref_rows_atc_fill',
        'sip_ref_rows_atc_col'

    ];

    public function formvalues($row,$col,$sub){

        return Sip_trx_form_value::join('sip_trx_row_values','sip_trx_row_values.sip_trx_row_values_code','=','sip_trx_form_values.sip_trx_form_values_code')
                            ->where('sip_trx_row_values.sip_trx_row_values_column_id',$col->sip_ref_columns_id)
                            ->where('sip_trx_row_values.sip_trx_row_values_row_id',$row->sip_ref_rows_id);

    }

    public function formvaluesbyuser($row,$col,$sub,$user){

        return Sip_trx_form_value::join('sip_trx_form_submissions','sip_trx_form_submissions.sip_trx_form_submission_id','=','sip_trx_form_values.sip_trx_form_values_submission_id')
                            ->join('sip_trx_row_values','sip_trx_row_values.sip_trx_row_values_code','=','sip_trx_form_values.sip_trx_form_values_code')
                            ->where('sip_trx_form_submissions.sip_trx_form_submission_user_id',$user->user_id)
                            ->where('sip_trx_row_values.sip_trx_row_values_column_id',$col->sip_ref_columns_id)
                            ->where('sip_trx_row_values.sip_trx_row_values_column_id',$col->sip_ref_columns_id)
                            ->where('sip_trx_row_values.sip_trx_row_values_row_id',$row->sip_ref_rows_id);

    }

    // aksesor
    public function getAtcValueAttribute($value)
    {
        if($this->sip_ref_rows_atc_fill){

            $col = explode('.', $this->sip_ref_rows_atc_col);

            $data = DB::table($col[0])->select($col[1])->first();

            return is_object($data) ? $data->{$col[1]} : '';   
        }

        return '';
    }

    public function codes()
    {
        return $this->hasMany('App\Sip_trx_row_value','sip_trx_row_values_row_id','sip_ref_rows_id');
    }

    public function grouprows()
    {
        return $this->hasMany('App\Sip_ref_row','sip_ref_rows_group_id','sip_ref_rows_id');
    }
    
    public function groupcolumns()
    {
        return $this->hasMany('App\Sip_ref_column','sip_ref_columns_group_id','sip_ref_rows_id');
    }

    public function children()
    {
        return $this->hasMany('App\Sip_ref_row','sip_ref_rows_parent_id','sip_ref_rows_id');
    }
    
    public function columnvalue(){
        
        return $this->belongsTo('App\Sip_ref_column','sip_trx_row_values_column_id','sip_ref_columns_id');

    }

    public function parent()
    {
        return $this->hasOne('App\Sip_ref_row','sip_ref_rows_id','sip_ref_rows_parent_id');
    }
    
}
