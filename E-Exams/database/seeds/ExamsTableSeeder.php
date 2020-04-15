<?php

use App\Subject\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = \App\Student\Student::find(1);
        $subjects = $student->getSubjects();

        foreach ($subjects as $subject) {
            $date = \Carbon\Carbon::now();
            $randomCode = Str::random(8);
            $exam = $subject->exams()->create([
                'start_time' => $date->format('Y-m-d H:i:s'),
                'end_time' => $date->addHours(2)->format('Y-m-d H:i:s'),
                'exam_time' => '2:0',
                'marks' => 100,
//                'exam_type' => 3,
                'exam_code' => $randomCode,
            ]);
            $structure = $exam->structures()->create([
                'chapter_id' => rand(1, 5),
                'question_category_id' => rand(1, 3),
                'question_type_id' => 1,
                'questions_count' => rand(2, 10),
            ]);
            $sum = 0;
            $ids = Question::getRandomQuestions($structure->questionCategory->id, $structure->questionType->id, $structure->questions_count)->pluck('id');
            $exam->questions()->attach($ids);
            $exam->questions->each(function ($question) use ($student, &$sum, $exam) {
                $answer = rand(0, 3);
                $option = $question->options[$answer];
                $sum += $option->correct;
                $student->examAnswers()->create([
                    'exam_id' => $exam->id,
                    'question_id' => $question->id,
                    'question_option_id' => $option->id,
                    'correct' => $option->correct,
                    'option_index' => $answer
                ]);
            });
            $percent = ($sum / $exam->questions->count()) * 100;
            $exam->update(['examined' => 1]);
            $marks = ($percent / 100) * $exam->marks;
            $student->examResults()->create([
                'subject_id' => $subject->id,
                'exam_id' => $exam->id,
                'marks' => $marks,
                'percent' => $percent,
                'success' => $percent > 50,
            ]);
        }
    }
}
