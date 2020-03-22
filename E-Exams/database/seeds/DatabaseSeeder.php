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
        $this->call(DepartmentsTableSeeder::class);
        $this->call(LevelsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(QuestionTypesTableSeeder::class);
        $this->call(QuestionCategoriesTableSeeder::class);
        $this->call(SubjectsTableSeeder::class);
        $this->call(ChaptersTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
        $this->call(TrainingExamsTableSeeder::class);


    }
}
