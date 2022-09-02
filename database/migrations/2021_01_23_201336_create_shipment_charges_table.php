<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("country_id");
            $table->unsignedBigInteger("state_id");
            $table->float('charge');

            $table->timestamps();
            $table->foreign('country_id')
            ->references('id')
            ->on('countries')
            ->onDelete('cascade');
            $table->foreign('state_id')
            ->references('id')
            ->on('states')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipment_charges');
    }
}
