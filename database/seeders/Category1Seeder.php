<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category1s')->insert([
            [
                "name" => "メイン1",
            ],
            [
                "name" => "メイン2",
            ],
            [
                "name" => "メイン3",
            ]
        ]);
    }
}
