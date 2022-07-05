<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product')->insert([
            'category_id' => 5,
            'section_id' => 1,
            'product_name'=>'Blue-T-shirt',
            'product_code'=>'BTOO1',
            'product_color'=>'Blue',
            'product_price'=>500,
            'product_discount'=>10,
            'main_image'=>'img.jpg',
            'description'=>'test',
            'meta_title'=>'test',
            'meta_description'=>'test',
            'meta_keywords'=>'test',
            'is_featured'=>0,
            'status'=>1

        ]);
        DB::table('product')->insert([
            'category_id' => 9,
            'section_id' => 1,
            'product_name'=>'Blue-causal-tshirt',
            'product_code'=>'BTOO11',
            'product_color'=>'Blue',
            'product_price'=>500,
            'product_discount'=>10,
            'main_image'=>'img.jpg',
            'description'=>'test',
            'meta_title'=>'test',
            'meta_description'=>'test',
            'meta_keywords'=>'test',
            'is_featured'=>0,
            'status'=>1

        ]);
    }
}
