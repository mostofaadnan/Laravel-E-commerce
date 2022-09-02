<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayPalCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_pal_carts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_no');
            $table->string('tokenid');
            $table->string('inputdate');
            $table->string("ref_no")->nullable();
            $table->integer('customer_id');
            $table->float("amount");
            $table->float("discount");
            $table->float("vat");
            $table->float("nettotal");
            $table->integer('paymenttype_id');
            $table->integer("user_id");
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
        Schema::dropIfExists('pay_pal_carts');
    }
}
