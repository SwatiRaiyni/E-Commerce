<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;
class SectionSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('section')->insert([
            'name' =>'Men',
            'status' => 1,

        ]);
        DB::table('section')->insert([
            'name' =>'Women',
            'status' => 1,

        ]);
        DB::table('section')->insert([
            'name' =>'Kids',
            'status' => 1,

        ]);
    }
}
