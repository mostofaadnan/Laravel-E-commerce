<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPaymentRecievesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_payment_recieves', function (Blueprint $table) {
            $table->id();
            $table->string('payment_no');
            $table->string('inputdate');
            $table->unsignedBigInteger('customer_id');
            $table->integer('amount');
            $table->float('recieve');
            $table->float('balancedue');
            $table->tinyinteger('payment_id');
            $table->text('paymentdescription')->nullable();
            $table->text('remark')->nullable();
            $table->integer('user_id');
            $table->timestamps();
            $table->text('comment')->nullable();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
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
        Schema::dropIfExists('customer_payment_recieves');
    }
}
