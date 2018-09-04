<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSipRefColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_ref_columns', function (Blueprint $table) {
            $table->increments('sip_ref_columns_id');
            $table->text('sip_ref_columns_title');
            $table->integer('sip_ref_columns_sub_id');
            $table->integer('sip_ref_columns_group_id');
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
        Schema::dropIfExists('sip_ref_columns');
    }
}
