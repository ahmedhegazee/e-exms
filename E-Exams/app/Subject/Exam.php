<?php

namespace App\Subject;

use App\ExamStructure;
use App\Student\Student;
use App\TrainingExam\TrainingExamAnswers;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function structures()
    {
        return $this->hasMany(ExamStructure::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }

    public function scopeType($query, $type)
    {
        return $query->where('exam_type', $type);
    }

    public static function correctingAnswers($exam, $answers, $questions, $isTrainingExam = false)// mode true for training , false for exams
    {
        $sum = 0;
        $mcq = ["true" => 0, 'false' => 0, 'total' => 0];
        $true_false_questions = ["true" => 0, 'false' => 0, 'total' => 0];
        $student = auth()->user()->student;
        $questions->each(function ($question) use ($student, $isTrainingExam, $exam, $answers, &$sum, &$mcq, &$true_false_questions) {
            $index = intval($answers[$question->id]);
            $option = $question->options[$index - 1];
            if ($option->correct) {
                if ($question->type->id == 1)
                    $mcq['true']++;
                else
                    $true_false_questions['true']++;
            }
            $sum += $option->correct;

            if ($isTrainingExam)
                Exam::createExamAnswer(null, $exam, $question, $option, $index, $isTrainingExam);
            else
                Exam::createExamAnswer($student, $exam, $question, $option, $index, $isTrainingExam);
        });

        $mcq['total'] = $exam->questions()->typeMCQ()->count();
        $mcq['false'] = Exam::getFalseAnswersCount($mcq['total'], $mcq['true']);
        $true_false_questions['total'] = $exam->questions()->typeTrueOrFalse()->count();
        $true_false_questions['false'] = Exam::getFalseAnswersCount($true_false_questions['total'], $true_false_questions['true']);
        $result['total_questions'] = $exam->questions->count();
        $result['score'] = $sum;
        $result['percent'] = ($result['score'] / $result['total_questions']) * 100;
        return Exam::createExamResult($student, $exam, $result, $mcq, $true_false_questions, $isTrainingExam);
    }

    public static function createExamResult($student, $exam, $result, $mcq, $true_false_questions, $isTrainingExam = false) // false for exam , true for training
    {
        if ($isTrainingExam) {
            $exam->update(['examined' => 1]);
            $exam->result()->create([
                'marks' => $result['percent'],
                'correct_answers' => $mcq['true'] + $true_false_questions['true'],
                'wrong_answers' => $mcq['false'] + $true_false_questions['false'],
            ]);
        } else {

            $student->examResults()->create([
                'subject_id' => $exam->subject->id,
                'exam_id' => $exam->id,
                'marks' => $result['score'],
                'percent' => $result['percent'],
                'success' => $result['percent'] > 50,
            ]);
        }
        return ['mcq' => $mcq, 'true_false' => $true_false_questions, 'result' => $result];
    }

    static function getFalseAnswersCount($totalQuestions, $trueQuestions)
    {
        $falseResult = $totalQuestions - $trueQuestions;
        return $falseResult < 0 ? 0 : $falseResult;
    }

    /**
     * @param $question
     */
    static function deletePreviousAnswer($question)
    {
        $prevAnswer = TrainingExamAnswers::where('question_id', $question->id)->first();
        if ($prevAnswer != null)
            $prevAnswer->delete();
    }

    public static function createExamAnswer($student, $exam, $question, $option, $index, $isTrainingExam)
    {
        if ($isTrainingExam) {
            Exam::deletePreviousAnswer($question);
            $exam->answers()->create([
                'question_id' => $question->id,
                'question_option_id' => $option->id,
                'correct' => $option->correct,
                'option_index' => $index,
            ]);
        } else {
            $student->examAnswers()->create([
                'exam_id' => $exam->id,
                'question_id' => $question->id,
                'question_option_id' => $option->id,
                'correct' => $option->correct,
                'option_index' => $index
            ]);
        }
    }
}
