<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;

class NewsletterSubscriber extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('newsletter_subscribers')->insert([
            'email' => 'swatiraiyani3127@gmail.com',
            'status' => 1,
        ]);
        DB::table('newsletter_subscribers')->insert([
            'email' => 'swati@gmail.com',
            'status' => 1,
        ]);
    }
}
