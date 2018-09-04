<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SipTrxUserLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_trx_user_logs', function(Blueprint $table) {

            $table->increments('sip_trx_user_logs_id');
            $table->integer('sip_trx_user_logs_user_id');
            $table->integer('sip_trx_user_logs_foreign_id');
            $table->integer('sip_trx_user_logs_to_id');
            $table->string('sip_trx_user_logs_type');
            $table->text('sip_trx_user_logs_desc');
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
        Schema::drop('sip_trx_user_logs');
    }
}
