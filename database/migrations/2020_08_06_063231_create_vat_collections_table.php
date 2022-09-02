<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVatCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vat_collections', function (Blueprint $table) {
            $table->id();
            $table->string('collection_no');
            $table->string('fromdate');
            $table->string('todate');
            $table->text('remark')->nullable();
            $table->float('amount');
            $table->tinyInteger('user_id');
            $table->tinyInteger('payment')->default(0);
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
        Schema::dropIfExists('vat_collections');
    }
}
