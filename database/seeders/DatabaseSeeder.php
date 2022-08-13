<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
        ]);
        \App\Models\Category::factory(10)->create();
        \App\Models\Company::factory(1)->create();
        \App\Models\BranchOffice::factory(10)->create();
        \App\Models\DutyStation::factory(10)->create();
    }
}
