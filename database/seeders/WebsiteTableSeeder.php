<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('websites')->insert([
            [
                'name' => 'Website one',
                'url' => 'https://www.websiteone.com',
            ], [
                'name' => 'Website two',
                'url' => 'https://www.websitetwo.com',
            ], [
                'name' => 'Website three',
                'url' => 'https://www.websitethree.com',
            ], [
                'name' => 'Website four',
                'url' => 'https://www.websitefour.com',
            ], [
                'name' => 'Website five',
                'url' => 'https://www.websitefive.com',
            ]
        ]);
    }
}
