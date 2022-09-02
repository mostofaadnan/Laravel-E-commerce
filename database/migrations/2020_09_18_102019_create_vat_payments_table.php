<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVatPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vat_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vat_id');
            $table->string('vat_payment_no');
            $table->foreign('vat_id')->references('id')->on('vat_collections');
            $table->integer('branch_id');
            $table->string('inputdate');
            $table->float('amount');
            $table->tinyInteger('payment_type');
            $table->text('paymentdescription');
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
        Schema::dropIfExists('vat_payments');
    }
}
