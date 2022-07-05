<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;

class bannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banners')->insert([
            'image' => 'banner1.png',
            'banner-title' => 'black Jacket',
            'banner-description' =>"askfdadsj",
            'status' =>1,
            'created_at' => now(),
        ]);
        DB::table('banners')->insert([
            'image' => 'banner2.png',
            'banner-title' => 'Half sleeve Jacket',
            'banner-description' =>"askfdadsj",
            'status' =>1,
            'created_at' => now(),
        ]);
        DB::table('banners')->insert([
            'image' => 'banner3.png',
            'banner-title' => 'black sleeve Jacket',
            'banner-description' =>"askfdadsj",
            'status' =>1,
            'created_at' => now(),
        ]);
    }

}
