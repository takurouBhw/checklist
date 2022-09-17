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
                "name" => "入居処理",
            ],
            [
                "name" => "退去処理",
            ],
            [
                "name" => "その他",
            ]
        ]);
    }
}
