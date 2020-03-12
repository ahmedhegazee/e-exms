<?php

use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $firstLevel= \App\Level::create([
            'level_title'=>'First Level'
        ]);
        $secondLevel=\App\Level::create([
            'level_title'=>'Second Level'
        ]);
        $thirdLevel= \App\Level::create([
            'level_title'=>'Third Level'
        ]);
        $fourthLevel= \App\Level::create([
            'level_title'=>'Fourth Level'
        ]);
        $firstLevel->departments()->syncWithoutDetaching([1,6]);
        $secondLevel->departments()->syncWithoutDetaching([1,6]);
        $thirdLevel->departments()->syncWithoutDetaching([2,3,4,5,6]);
        $fourthLevel->departments()->syncWithoutDetaching([2,3,4,5,6]);
    }
}
