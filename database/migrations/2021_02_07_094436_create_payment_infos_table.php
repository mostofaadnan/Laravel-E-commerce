<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("invoice_id");
            $table->text("tran_id")->nullable();
            $table->float("amount");
            $table->text("card_type")->nullable();
            $table->float("store_amount");
            $table->text("card_no")->nullable();
            $table->text("bank_tran_id");
            $table->text("tran_date");
            $table->text("card_issuer");
            $table->text("card_brand");
            $table->text("card_issuer_country");
            $table->text("store_id");
            $table->text("currency_rate");
            $table->timestamps();
            $table->foreign('invoice_id')
            ->references('id')
            ->on('orders')
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
        Schema::dropIfExists('payment_infos');

    }
}
