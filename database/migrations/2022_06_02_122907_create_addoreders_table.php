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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('name')->after('address')->nullable();
            $table->string('email')->after('user_id')->nullable();
            $table->integer('grand_total')->after('email')->nullable();
            $table->integer('pincode')->after('payment_status')->nullable();
            $table->string('mobile')->after('pincode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'name',
                'email',
                'grand_total',
                'pincode',
                'mobile'

            ]));
        });
    }
};
