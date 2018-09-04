<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SipTrxFormSubmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_trx_form_submissions', function (Blueprint $table) {
            $table->increments('sip_trx_form_submission_id');
            $table->integer('sip_trx_form_submission_user_id');
            $table->integer('sip_trx_form_submission_form_id');
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
        Schema::dropIfExists('sip_trx_form_submissions');
    }
}
