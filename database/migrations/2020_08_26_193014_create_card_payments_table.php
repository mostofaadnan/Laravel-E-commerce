<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_payments', function (Blueprint $table) {
            $table->id();
            $table->string('inputdate');
            $table->float('cashin');
            $table->float('cashout');
            $table->float('balance');
            $table->string('card_id');
            $table->string('strip_id');
            $table->string('banktransection_id');
            $table->string('source');
            $table->string('card_on_name')->nullable();
            $table->string('brand')->nullable();
            $table->string('last_four')->nullable();
            $table->string('country')->nullable();
            $table->integer('payment_id');
            $table->string('type');
            $table->tinyInteger('type_id')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('card_payments');
    }
}
