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
        Schema::table('orders_logs', function (Blueprint $table) {
            $table->string('reason')->after('order_status')->nullable();
            $table->string('updated_by')->after('reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders_logs', function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'reason',
                'updated_by'
            ]));
        });
    }
};
