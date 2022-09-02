<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaypalPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_payments', function (Blueprint $table) {
            $table->id();
            $table->string('token')->nullable();
            $table->string('payerid')->nullable();
            $table->string('time')->nullable();
            $table->string('currency')->nullable();
            $table->tinyInteger('branch_id');
            $table->string('description')->nullable();
            $table->float('amount')->default(0);
            $table->integer('type_id');
            $table->tinyInteger('type')->nullable();
            $table->integer("user_id");
            $table->timestamps();
            $table->tinyinteger('cancel')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paypal_payments');
    }
}
