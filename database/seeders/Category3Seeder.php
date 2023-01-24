<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category3s')->insert([
            [
                "name" => "ハイツA101号室",
                "category1_id" =>  1,
                "category2_id" =>  1,
            ],
            [
                "name" => "102号室",
                "category1_id" =>  1,
                "category2_id" =>  1,
            ],
            [
                "name" => "103号室",
                "category1_id" =>  1,
                "category2_id" =>  1,
            ]
        ]);
    }
}
