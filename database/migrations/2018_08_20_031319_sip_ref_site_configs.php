<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SipRefSiteConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_trx_site_configs', function(Blueprint $table) {

            $table->increments('sip_trx_site_configs_id');
            $table->string('sip_trx_site_configs_title');
            $table->string('sip_trx_site_configs_icon');
            $table->string('sip_trx_site_configs_logo');
            $table->text('sip_trx_site_configs_description');
            $table->text('sip_trx_site_configs_address');
            $table->text('sip_trx_site_configs_key_sisdinkes');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sip_trx_site_configs');
    }
}
