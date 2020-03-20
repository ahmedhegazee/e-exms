<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects=\App\Subject\Subject::all();
        $categories=['A','B','C'];
        $subjects->each(function ($subject) use ($categories) {
            $subject->chapters->each(function($chapter) use ($categories) {
                    for($category=1;$category<4;$category++){
                        for ($q=1;$q<4;$q++){
                            //MCQ
                            $question=$chapter->questions()->create([
                                'question_content'=>'Question '.$q,
                                'question_category_id'=>$category,
                                'question_type_id'=>1//MCQ
                            ]);
                            for($option=1;$option<5;$option++){
                                $question->options()->create([
                                    'option_content'=>'Option '.$option,
                                ]);
                            }
                            $question->options[rand(0,3)]->update(['correct'=>1]);
                                    //T/F
                            $question=$chapter->questions()->create([
                                'question_content'=>'Question '.$q,
                                'question_category_id'=>$category,
                                'question_type_id'=>2//T|f
                            ]);

                            $question->options()->create([
                                'option_content'=>'True',
                            ]);
                            $question->options()->create([
                                'option_content'=>'False',
                            ]);

                            $question->options[rand(0,1)]->update(['correct'=>1]);
                        }

                    }


            });
//            for ($i=1;$i<6;$i++){
//                $subject->chapters()->create([
//                    'chapter_title'=>'Chapter '.$i
//                ]);
//            }
        });
    }
}
