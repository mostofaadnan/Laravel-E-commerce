<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->string('inputdate');
            $table->string("ref_no")->nullable();
            $table->tinyinteger('type_id');
            $table->integer('customer_id');
            $table->float("amount");
            $table->float("discount");
            $table->float("vat");
            $table->float("shipment")->default(0)->nullable();
            $table->float("nettotal");
            $table->integer('paymenttype_id');
            $table->tinyinteger("status");
            $table->integer("user_id");
            $table->tinyinteger("vatcol")->default(0);
            $table->integer("vatcollection_id")->default(0);
            $table->float('pay')->nullable();
            $table->timestamps();
            $table->tinyinteger('cancel')->nullable()->default(0);
            $table->text('comment')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
