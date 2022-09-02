<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayPalCartDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_pal_cart_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("paypal_id");
            $table->foreign('paypal_id')->references('id')->on('pay_pal_carts');
            $table->integer("item_id");
            $table->string("name");
            $table->float("mrp");
            $table->float("tp");
            $table->tinyinteger("unit_id");
            $table->float("qty");
            $table->float("amount");
            $table->float("vat");
            $table->float("discount");
            $table->float("nettotal");
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
        Schema::dropIfExists('pay_pal_cart_details');
    }
}
