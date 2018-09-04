<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSipRefRows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_ref_rows', function (Blueprint $table) {
            $table->increments('sip_ref_rows_id');
            $table->text('sip_ref_rows_title');
            $table->enum('sip_ref_rows_type_row',array('row','group'));
            $table->enum('sip_ref_rows_type_parent',array('parent','child'));
            $table->integer('sip_ref_rows_sub_id');
            $table->integer('sip_ref_rows_group_id');
            $table->integer('sip_ref_rows_parent_id');
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
        Schema::dropIfExists('sip_ref_rows');
    }
}
