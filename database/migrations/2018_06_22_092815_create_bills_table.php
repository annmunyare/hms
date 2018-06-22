<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('billId');
            $table->unsignedInteger('visitId');
            $table->foreign('visitId')->references('visitId')->on('visits')->onDelete('cascade');
            $table->unsignedInteger('serviceId');
            $table->foreign('serviceId')->references('serviceId')->on('services')->onDelete('cascade');
            $table->double('amount');
            $table->integer('quantity');
            $table->date('billTime');
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
        Schema::dropIfExists('bills');
    }
}
