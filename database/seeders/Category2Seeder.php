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
                "category2_name" => "退去手続き",
                "category1_id" =>  1,
            ],
            [
                "category2_name" => "入居手続き",
                "category1_id" =>  1,
            ],
            [
                "category2_name" => "その他手続き",
                "category1_id" =>  1,
            ]
        ]);
    }
}
