<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->tinyInteger('autometic_store');
            $table->tinyInteger('vat_applicable');
            $table->tinyInteger('print');
            $table->tinyInteger('print_credit');
            $table->text('footermsg')->nullable();
            $table->string('cash_invoice')->nullable();
            $table->string('credit_invoice')->nullable();
            $table->text('card_key')->nullable();
            $table->text('card_secret')->nullable();
            $table->text('paypal_username')->nullable();
            $table->text('paypal_password')->nullable();
            $table->text('paypal_secret')->nullable();
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
        Schema::dropIfExists('sale_configs');
    }
}
