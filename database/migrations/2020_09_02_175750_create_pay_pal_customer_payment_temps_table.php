<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayPalCustomerPaymentTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_pal_customer_payment_temps', function (Blueprint $table) {
            $table->id();
            $table->string('payment_no');
            $table->string('inputdate');
            $table->unsignedBigInteger('customer_id');
            $table->integer('amount');
            $table->float('recieve');
            $table->float('balancedue');
            $table->text('remark')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('pay_pal_customer_payment_temps');
    }
}
