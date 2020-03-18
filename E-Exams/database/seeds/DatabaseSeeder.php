<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         Artisan::call('passport:install --force');
        $this->call(RolesTableSeeder::class);
        $this->call(StudyingYearsTableSeeder::class);
        $this->call(StudyingTermsTableSeeder::class);
        $this->call(StudyingPlanTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(LevelsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(QuestionTypesTableSeeder::class);
    }
}
