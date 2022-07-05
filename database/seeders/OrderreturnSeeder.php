<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;

class OrderreturnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('return_order')->insert([
            'order_id' => 1,
            'user_id' => 1,
            'product_size' =>'small',
            'product_code'=>'BTOO1',
            'return_reason'=>'Quality is not so good',
            'return_status'=>'Pending',
            'comment'=>'not good'
        ]);

    }
}
