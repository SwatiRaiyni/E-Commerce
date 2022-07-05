<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProduceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' =>'LG mobile',
            'price' => '200',
            'category' => 'mobile',
            'description' => 'A smartphone with 4gb ram and much more features',
            'gallery'=> 'myimage.jpg',
            'created_at'=>now()

        ]);
        DB::table('products')->insert([
            'name' =>'Oppo mobile',
            'price' => '300',
            'category' => 'mobile',
            'description' => 'A smartphone with 8gb ram and much more features',
            'gallery'=> 'myimage.jpg',
            'created_at'=>now()
        ]);
        DB::table('products')->insert([
            'name' =>'Samsang TV',
            'price' => '200',
            'category' => 'TV',
            'description' => 'A smart tv with much more features',
            'gallery'=> 'myimage.jpg',
            'created_at'=>now()
        ]);
    }
}
