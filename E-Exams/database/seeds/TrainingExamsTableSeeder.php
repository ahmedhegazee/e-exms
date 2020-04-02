<?php

use App\Subject\Question;
use App\TrainingExam\TrainingExamAnswers;
use Illuminate\Database\Seeder;

class TrainingExamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = \App\Student\Student::find(1);
       $subject= $student->getSubjects()->first();

     for($i=0;$i<10;$i++){
         $exam= $student->trainingExams()->create(['subject_id'=>$subject->id]);
         $structure = $exam->structures()->create([
             'chapter_id' => rand(1,5),
             'question_category_id' => rand(1,3),
             'question_type_id' => 1,
             'questions_count' => rand(2,10),
         ]);
         $sum=0;
         $correctAnswers=0;
         $wrongAnswers=0;
         $ids = Question::getRandomQuestions($structure->questionCategory->id, $structure->questionType->id, $structure->questions_count)->pluck('id');
         $exam->questions()->attach($ids);
         $exam->questions->each(function($question) use (&$sum, $exam,&$correctAnswers,&$wrongAnswers) {
             $answer= rand(0,3);
             $option = $question->options[$answer];
             $sum += $option->correct;
             if($option->correct)
                 $correctAnswers++;
             else
                 $wrongAnswers++;
             $this->deletePreviousAnswer($question);
             $exam->answers()->create([
                 'question_id' => $question->id,
                 'question_option_id' => $option->id,
                 'correct' => $option->correct,
                 'option_index'=>$answer
             ]);
         });
         $percent =($sum /$exam->questions->count())*100;
         $exam->update(['examined'=>1]);
         $exam->result()->create([
             'marks' => $percent,
             'correct_answers' => $correctAnswers,
             'wrong_answers' => $wrongAnswers,
         ]);
//         sleep(30);
     }
    }


    /**
     * @param $question
     */
    public function deletePreviousAnswer($question)
    {
        $prevAnswer = TrainingExamAnswers::where('question_id', $question->id)->first();
        if ($prevAnswer != null)
            $prevAnswer->delete();
    }

}
