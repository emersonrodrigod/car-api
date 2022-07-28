<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('model');
            $table->string('license_plate');
            $table->string('manufacturing_year');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['license_plate', 'deleted_at']);
        });

        Schema::create('car_user', function(Blueprint $table) {
           $table->uuid('id')->primary();
           $table->foreignUuid('car_id')->references('id')->on('cars');
           $table->foreignUuid('user_id')->references('id')->on('users');
           $table->unique(['car_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
