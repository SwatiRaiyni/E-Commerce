<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('section_id');
            $table->string('product_name');
            $table->string('product_code');
            $table->string('product_color');
            $table->bigInteger('product_price');
            $table->float('product_discount');
            $table->string('main_image');
            $table->text('description');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->string('meta_keywords');
            $table->boolean('is_featured');
            $table->boolean('status');
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
        Schema::dropIfExists('product');
    }
};
