<?php

use Illuminate\Database\Seeder;

class QuestionCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\QuestionCategory::create([
            'category'=>'A',
        ]);
        \App\QuestionCategory::create([
            'category'=>'B',
        ]);
        \App\QuestionCategory::create([
            'category'=>'C',
        ]);
    }
}
