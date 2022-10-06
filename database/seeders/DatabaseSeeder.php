<?php

namespace Database\Seeders;

use App\Models\Checklist;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ChecklistWorkSeeder;
use Database\Seeders\Category1Seeder;
use Database\Seeders\Category2Seeder;
use Database\Seeders\Category3Seeder;
use Database\Seeders\ChecklistSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $num = 150;
        // \App\Models\Category::factory(10)->create();
        // \App\Models\BranchOffice::factory(10)->create();
        // \App\Models\DutyStation::factory(10)->create();
        $this->call([
            UserSeeder::class,
            // Category1Seeder::class,
            // Category2Seeder::class,
            // Category3Seeder::class,
            // ChecklistSeeder::class,
            // ChecklistWorkSeeder::class,
        ]);
        \App\Models\Company::factory($num)->create();
        \App\Models\Category1::factory($num)->create();
        \App\Models\Category2::factory($num)->create();
        // \App\Models\Category3::factory(1)->create();
        \App\Models\Checklist::factory($num)->create();
        \App\Models\ChecklistWork::factory($num)->create();

        // \App\Models\ChecklistTodo::factory(1)->create();
        // \App\Models\ChecklistParticipant::factory(1)->create();
        // \App\Models\ChecklistWork::factory(1)->create();
        // \App\Models\ChecklistTodoWork::factory(1)->create();
    }
}
