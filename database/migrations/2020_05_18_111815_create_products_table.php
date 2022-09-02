<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->string('name');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('brand_id');
            $table->text('remark')->nullable();
            $table->float('tp');
            $table->float('mrp');
            $table->float('discount')->default(0);
            $table->integer('parcentage')->default(0);
            $table->tinyinteger('VatSetting_id')->nullable();
            $table->float('vatvalue')->nullable();
            $table->string('openingDate');
            $table->tinyinteger('status');
            $table->integer('unit_id');
            $table->integer('admin_id');
            $table->text("image");
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
        Schema::dropIfExists('products');
    }
}
