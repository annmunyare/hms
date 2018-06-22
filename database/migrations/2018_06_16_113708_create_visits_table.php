<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->increments('visitId');
            $table->unsignedInteger('patientId');
            $table->foreign('patientId')->references('patientId')->on('patients')->onDelete('cascade');
             $table->date('visitDate');
            $table->tinyInteger('visitType');
            $table->date('exitTime');
             $table->tinyInteger('visitStatus');
             $table->string('patientName', 100);
             $table->date('patientDateOfBirth');
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
        Schema::dropIfExists('visits');
    }
}
