<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSipTrxRowvalues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_trx_row_values', function (Blueprint $table) {
            $table->increments('sip_trx_row_values_id');
            $table->string('sip_trx_row_values_code');
            $table->integer('sip_trx_row_values_row_id');
            $table->integer('sip_trx_row_values_column_id');
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
        Schema::dropIfExists('sip_trx_row_values');
    }
}
