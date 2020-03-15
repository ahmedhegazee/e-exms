<?php

use Illuminate\Database\Seeder;

class StudyingTermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\StudyingTerm::create([
            'term'=>'Autumn Term'
        ]);
        \App\StudyingTerm::create([
            'term'=>'Spring Term'
        ]);
        \App\StudyingTerm::create([
            'term'=>'Summer Term'
        ]);
    }
}
