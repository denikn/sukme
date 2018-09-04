<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SipTrxUserNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_trx_user_notifications', function(Blueprint $table) {

            $table->increments('sip_trx_user_notifications_id');
            $table->integer('sip_trx_user_notifications_user_id');
            $table->integer('sip_trx_user_notifications_foreign_id');
            $table->text('sip_trx_user_notifications_text');
            $table->string('sip_trx_user_notifications_type');
            $table->enum('sip_trx_user_notifications_status',array('read','unread'));
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
        Schema::drop('sip_trx_user_notifications');
    }
}
