<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productsattribute')->insert([
            'product_id' => 1,
            'size' => 'small',
            'price' =>1200,
            'stock' => 10,
            'code' => 'BCT11' ,
            'status' => 1,

        ]);
        DB::table('productsattribute')->insert([
            'product_id' => 1,
            'size' => 'medium',
            'price' => 2000,
            'stock' =>2,
            'code' => 'ASWW' ,
            'status' => 1,

        ]);
        DB::table('productsattribute')->insert([
            'product_id' => 1,
            'size' => 'large',
            'price' => 2000,
            'stock' =>21,
            'code' => 'ASQQWW' ,
            'status' => 1,

        ]);
    }
}
