<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("invoice_id");
            $table->unsignedBigInteger("customer_id");
            $table->unsignedBigInteger("item_id");
            $table->text('spacification')->nullable();
            $table->float("mrp");
            $table->float("tp");
            $table->tinyinteger("unit_id");
            $table->float("qty");
            $table->float("amount");
            $table->float("vat");
            $table->float("discount");
            $table->float("nettotal");
            $table->timestamps();
            $table->tinyinteger('cancel')->default(0);
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
        Schema::dropIfExists('order_details');
    }
}
