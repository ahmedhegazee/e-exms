<?php

use Illuminate\Database\Seeder;

class StudyingPlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $year= \App\StudyingYear::first();
        $terms=\App\StudyingTerm::all();
        $year->terms()->syncWithoutDetaching($terms->pluck('id'));
        $firstTerm=$year->terms->first();
        $year->terms()->updateExistingPivot($firstTerm,['is_current'=>1]);
    }
}
