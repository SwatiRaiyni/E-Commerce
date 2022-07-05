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
        Schema::table('ordersproducts', function (Blueprint $table) {
            $table->string('item_status')->after('product_qty')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordersproducts', function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'item_status'
            ]));
        });
    }
};
