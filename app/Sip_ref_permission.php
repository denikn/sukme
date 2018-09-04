<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sip_ref_permission extends Model
{
	
	protected $primaryKey = 'sip_ref_permissions_id';
	
    protected $fillable = [
        
        'sip_ref_permissions_name',
        'sip_ref_permissions_code'

    ];
    
    public static $columns = [
        
        'sip_ref_permissions_name',
        'sip_ref_permissions_code'

    ];

}
