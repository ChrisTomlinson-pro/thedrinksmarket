<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->integer('base_price');
            $table->integer('version');
            $table->string('square_item_id');
            $table->string('pricing_type');
            $table->string('imagePath')->nullable();
            $table->integer('max_price');
            $table->integer('min_price');
            $table->integer('increments_up');
            $table->integer('increments_down');
            $table->integer('crash_price');
            $table->boolean('active');
            $table->string('name');
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
        Schema::dropIfExists('items');
    }
}
