<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSipSubForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_ref_sub_forms', function (Blueprint $table) {
            $table->increments('sip_ref_sub_forms_id');
            $table->text('sip_ref_sub_forms_title');
            $table->integer('sip_ref_sub_forms_form_id');
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
        Schema::dropIfExists('sip_ref_sub_forms');
    }
}
