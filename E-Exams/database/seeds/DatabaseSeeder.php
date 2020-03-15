<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(StudyingYearsTableSeeder::class);
        $this->call(StudyingTermsTableSeeder::class);
        $this->call(StudyingPlanTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(LevelsTableSeeder::class);
    }
}
