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
        Schema::table('cart', function (Blueprint $table) {

            $table->string('session_id')->after('user_id')->nullable();
            $table->text('size')->after('product_id')->nullable();
            $table->bigInteger('quantity')->after('size')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cartadd', function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'session_id',
                'size',
                'quantity',

            ]));
        });
    }
};
