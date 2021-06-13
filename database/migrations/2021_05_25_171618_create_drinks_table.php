<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drinks', function (Blueprint $table) {
            $table->id();
            $table->string('imagePath')->nullable();
            $table->integer('max_price');
            $table->integer('min_price');
            $table->integer('increments_up');
            $table->integer('increments_down');
            $table->boolean('active');
            $table->string('name');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('modifier_id')->nullable();
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('drinks');
    }
}
