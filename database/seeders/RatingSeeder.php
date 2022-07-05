<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ratings')->insert([
            'user_id' => 1,
            'product_id' => 1,
            'review' => 'Average Product',
            'ratings' => 2,
            'status'=> 0,
            'created_at'=>now()
        ]);
        DB::table('ratings')->insert([
            'user_id' => 1,
            'product_id' => 4,
            'review' => 'Good product',
            'ratings' => 4 ,
            'status'=> 0,
            'created_at'=>now()
        ]);
    }
}
