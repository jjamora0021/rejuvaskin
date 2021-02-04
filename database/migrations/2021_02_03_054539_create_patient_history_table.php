<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_history', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id');
            $table->string('last_visit');
            $table->string('last_procedure');
            $table->longText('before_image');
            $table->longText('after_image');
            $table->string('bill');
            $table->string('discount');
            $table->longText('remarks');
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
        Schema::dropIfExists('patient_history');
    }
}
