<?php

use Illuminate\Database\Seeder;

class QuestionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\QuestionType::create([
            'type'=>'MCQ'
        ]);
        \App\QuestionType::create([
            'type'=>'True\False'
        ]);
    }
}
