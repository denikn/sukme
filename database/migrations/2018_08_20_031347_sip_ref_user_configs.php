<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SipRefUserConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_trx_user_configs', function(Blueprint $table) {

            $table->increments('sip_trx_user_configs_id');
            $table->enum('sip_trx_user_configs_trf_data_type',array('bulk','single'));
            $table->integer('sip_trx_user_configs_user_id');
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
        Schema::drop('sip_trx_user_configs');
    }
}
