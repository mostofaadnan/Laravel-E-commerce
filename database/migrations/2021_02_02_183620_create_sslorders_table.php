<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSslordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sslorders', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('email');
            $table->text('mobile_no');
            $table->integer('country_id');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->text('address');
            $table->text('address_one');
            $table->float("amount");
            $table->float("discount");
            $table->float("vat");
            $table->float("shipment")->default(0)->nullable();
            $table->float("nettotal");
            $table->tinyinteger('paymenttype_id')->default(3);
            $table->tinyinteger("status");
            $table->text("transaction_id");
            $table->string('currency');
            $table->text("details");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sslorders');
    }
}
