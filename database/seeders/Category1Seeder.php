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
                "category1_name" => "入居処理",
            ],
            [
                "category1_name" => "退去処理",
            ],
            [
                "category1_name" => "その他",
            ]
        ]);
    }
}
