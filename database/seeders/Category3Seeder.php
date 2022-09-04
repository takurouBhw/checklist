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
                "name" => "10q",
                "category1_id" =>  1,
                "category2_id" =>  1,
            ],
            [
                "name" => "102",
                "category1_id" =>  2,
                "category2_id" =>  2,
            ],
            [
                "name" => "103",
                "category1_id" =>  3,
                "category2_id" =>  3,
            ]
        ]);
    }
}
