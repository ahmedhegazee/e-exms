<?php

use Illuminate\Database\Seeder;

class StudyingYearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\StudyingYear::create([
            'year'=>'2019-2020'
        ]);
    }
}
