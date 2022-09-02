<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumberFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_formats', function (Blueprint $table) {
            $table->id();
            $table->string('branch')->nullable();
            $table->string('product')->nullable();
            $table->string('purchase')->nullable();
            $table->string('purchasereturn')->nullable();
            $table->string('grn')->nullable();
            $table->string('cashinvoice')->nullable();
            $table->string('creditinvoice')->nullable();
            $table->string('salereturn')->nullable();
            $table->string('supplierpayment')->nullable();
            $table->string('creditpayment')->nullable();
            $table->string('expneses')->nullable();
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
        Schema::dropIfExists('number_formats');
    }
}
