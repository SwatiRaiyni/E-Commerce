<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            'parent_id' => 0,
            'section_id' => 1,
            'category_name' =>"T-Shirt",
            'category_image' =>"",
            'category_discount' => 0 ,
            'description' => '',
            'url'=>'t-shirts',
            'meta_title'=>'',
            'meta_description'=>'',
            'meta_keywords'=>'',
            'status'=>1

        ]);
    }
}
