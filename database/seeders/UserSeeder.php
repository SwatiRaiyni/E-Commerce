<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' =>'Swati Raiyani',
            'DOB' => '2001-09-03',
            'phone' => '9898945309',
            'Profile'=>'myprofile.jpg',
            'UserType' => 1,
            'IsApproved'=>1,
            'email'=>'swatiraiyani3127@gmail.com',
            'password'=>Hash::make('Swati@3127'),
            'created_at'=>now(),

        ]);
        DB::table('users')->insert([
        'name' =>'Admin Raiyani',
        'DOB' => '2001-09-03',
        'phone' => '9898945309',
        'Profile'=>'myprofile.jpg',
        'UserType' => 2,
        'IsApproved'=>1,
        'email'=>'admin@gmail.com',
        'password'=>Hash::make('admin@3127'),
        'created_at'=>now(),
        ]);

    }
}
