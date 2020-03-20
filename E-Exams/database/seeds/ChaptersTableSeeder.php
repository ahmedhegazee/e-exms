<?php

use Illuminate\Database\Seeder;

class ChaptersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects=\App\Subject\Subject::all();
        foreach ($subjects as $subject){
            for ($i=1;$i<6;$i++){
                $subject->chapters()->create([
                    'chapter_title'=>'Chapter '.$i
                ]);
            }
        }
    }
}
