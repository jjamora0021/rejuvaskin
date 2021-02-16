<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeKeepingDisputes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_keeping_disputes', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->date('date_in_dispute');
            $table->enum('type_of_dispute', ['time_in', 'time_out', 'total_hours', 'others']);
            $table->string('dispute')->nullable();
            $table->enum('status',['approved','declined','pending'])->default('pending');
            $table->string('approved_by')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('time_keeping_disputes');
    }
}
