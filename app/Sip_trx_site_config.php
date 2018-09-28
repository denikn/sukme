<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sip_trx_site_config extends Model
{
	protected $primaryKey = 'sip_trx_site_configs_id';

    protected $fillable = [
        
        'sip_trx_site_configs_title',
        'sip_trx_site_configs_icon',
        'sip_trx_site_configs_logo',
        'sip_trx_site_configs_description',
        'sip_trx_site_configs_puskemas_name',
        'sip_trx_site_configs_puskemas_address',
        'sip_trx_site_configs_puskemas_phone',
        'sip_trx_site_configs_puskemas_code',
        'sip_trx_site_configs_address',
        'sip_trx_site_configs_key_sisdinkes',
        'sip_trx_site_configs_trf_data_type	',
        'sip_trx_site_configs_trf_type'

    ];

    // aksesor
    public function getSipTrxSiteConfigsLogoAttribute($value)
    {
        $path = asset('/config/'.$value);
        return $path;
    }

}
