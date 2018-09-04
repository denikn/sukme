<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SipTrxUserPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_trx_user_permissions', function (Blueprint $table) {
            $table->increments('sip_trx_user_permissions_id');
            $table->integer('sip_trx_user_permissions_user_id');
            $table->integer('sip_trx_user_permissions_permission_id');
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
        Schema::dropIfExists('sip_trx_user_permissions');
    }
}
