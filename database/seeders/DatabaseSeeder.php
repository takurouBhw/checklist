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
        // \App\Models\Category::factory(10)->create();
        // \App\Models\BranchOffice::factory(10)->create();
        // \App\Models\DutyStation::factory(10)->create();
        $this->call([
            UserSeeder::class,
        ]);
        \App\Models\Company::factory(30)->create();
        // \App\Models\Checklist::factory(1)->create();
        // \App\Models\ChecklistTodo::factory(1)->create();
        // \App\Models\ChecklistParticipant::factory(1)->create();
        // \App\Models\ChecklistWork::factory(1)->create();
        // \App\Models\ChecklistTodoWork::factory(1)->create();
    }
}
