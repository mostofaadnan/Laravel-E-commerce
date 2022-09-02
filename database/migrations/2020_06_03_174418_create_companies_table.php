<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('postalcode')->nullable();
            $table->text('TIN')->nullable();
            $table->tinyinteger('status')->nullable();
            $table->text('mobile_no')->nullable();
            $table->text('tell_no')->nullable();
            $table->text('fax_no')->nullable();
            $table->text('companyemail')->nullable();
            $table->text('website')->nullable();
            $table->string('Estd')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->text('time_zone')->nullable();
            $table->text('language')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
