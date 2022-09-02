<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_debts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->float('openingBalance')->default(0);
            $table->float('cashinvoice')->default(0);
            $table->float('creditinvoice')->default(0);
            $table->float('order')->default(0);
            $table->float('totaldiscount')->default(0);
            $table->float('payment')->default(0);
            $table->float('salereturn')->default(0)->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('trn_id')->default(0)->nullable();
            $table->tinyinteger('cancel')->nullable()->default(0);
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
        Schema::dropIfExists('customer_debts');
    }
}
