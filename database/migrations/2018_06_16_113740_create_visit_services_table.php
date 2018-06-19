<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_services', function (Blueprint $table) {
            $table->increments('visit_servie_id');
            $table->integer('visit_id');
            $table->integer('service_id');
            $table->double('amount');
            $table->integer('quantity');
            $table->date('bill_time');
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
        Schema::dropIfExists('visit__services');
    }
}
