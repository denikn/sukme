<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSipTrxFormValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_trx_form_values', function (Blueprint $table) {
            $table->increments('sip_trx_form_values_id');
            $table->text('sip_trx_form_values_value_string');
            $table->integer('sip_trx_form_values_value_number');
            $table->string('sip_trx_form_values_code');
            $table->integer('sip_trx_form_values_form_id');
            $table->integer('sip_trx_form_values_sub_id');
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
        Schema::dropIfExists('sip_trx_form_values');
    }
}
