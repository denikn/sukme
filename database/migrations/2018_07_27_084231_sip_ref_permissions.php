<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SipRefPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_ref_permissions', function (Blueprint $table) {
            $table->increments('sip_ref_permissions_id');
            $table->string('sip_ref_permissions_name');
            $table->string('sip_ref_permissions_code');
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
        Schema::dropIfExists('sip_ref_permissions');
    }
}
