<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sliders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("type_id");
            $table->unsignedBigInteger("product_id");
            $table->timestamps();
            $table->foreign('type_id')
            ->references('id')
            ->on('product_slider_types')
            ->onDelete('cascade');
            $table->foreign('product_id')
            ->references('id')
            ->on('products')
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
        Schema::dropIfExists('product_sliders');
    }
}
