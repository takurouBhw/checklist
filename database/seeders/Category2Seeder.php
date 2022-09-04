<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category2s')->insert([
            [
                "name" => "物件1",
                "category1_id" =>  1,
            ],
            [
                "name" => "物件2",
                "category1_id" =>  2,
            ],
            [
                "name" => "物件3",
                "category1_id" =>  3,
            ]
        ]);
    }
}
