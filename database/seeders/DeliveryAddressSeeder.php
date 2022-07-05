<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;
class DeliveryAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deliveryaddresses')->insert([
            'user_id' => 1,
            'name' => "Swati",
            'address' =>"24-FF Kambhumi Soci , Nr. Bapa Sitaram Chock,Ahmedabad",
            'pincode' => 380024,
            'mobile' => "9898945309" ,
            'status' => 1,
            'created_at'=> now(),
        ]);
        DB::table('deliveryaddresses')->insert([
            'user_id' => 6,
            'name' => "Test",
            'address' =>"24-FF Kambhumi Soci , Nr. Bapa Sitaram Chock,Ahmedabad",
            'pincode' => 382350,
            'mobile' => "9825646345" ,
            'status' => 1,
            'created_at'=> now(),
        ]);
    }
}
