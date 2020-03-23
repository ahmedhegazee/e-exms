<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamQuestionsResource;
use App\Http\Resources\ExamStructureResource;
use App\Http\Resources\TrainingExamsResultResource;
use App\Subject\Question;
use App\Subject\Subject;
use App\TrainingExam\TrainingExam;
use App\TrainingExam\TrainingExamAnswers;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

class TrainingExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Subject $subject
     * @return JsonResponse|AnonymousResourceCollection|void
     */
    public function store(Request $request, Subject $subject)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }
        $exam = auth()->user()->student->trainingExams()->create([
            'subject_id' => $subject->id,
        ]);
//        dd($request->get('structures'));
        collect($request->get('structures'))->each(function ($structure) use ($exam) {
            $structure = $exam->structures()->create([
                'chapter_id' => intval($structure['chapter']),
                'question_category_id' => intval($structure['category']),
                'question_type_id' => intval($structure['type']),
                'questions_count' => intval($structure['count']),
            ]);
            $ids = Question::getRandomQuestions($structure->questionCategory->id, $structure->questionType->id, $structure->questions_count)->pluck('id');
            $exam->questions()->attach($ids);
        });
        $questions = ExamQuestionsResource::collection($exam->questions)->jsonSerialize();
        return response()->json(['exam' => $exam->id, 'questions' => $questions]);
//        return ExamStructureResource::collection($exam->structures);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\TrainingExam\TrainingExam $trainingExam
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingExam $trainingExam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\TrainingExam\TrainingExam $trainingExam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingExam $trainingExam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subject $subject
     * @param TrainingExam $training
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Subject $subject, TrainingExam $training)
    {
        if(is_null($training->result))
            return response()->json(['error'=>'this exam is not solved']);
        $training->structures()->delete();
        $training->questions()->detach($training->questions->pluck('id'));
        $training->delete();
        return response()->json(['message' => 'successfully deleting']);
    }

    public function storeAnswers(Request $request, TrainingExam $exam)
    {

        if(!is_null($exam->result))
            return response()->json(['error'=>'this exam is solved']);
        $validator= $this->validateAnswers($request->all());
        if($validator->fails())
            return response()->json(['errors'=>$validator->errors()]);
//        $questions = collect($request->get('questions'));
        $answers = $request->get('answers');
//        dd(count($answers));
//        dd($exam->questions->count());
        if(count($answers)!= $exam->questions->count())
            return response()->json(['error'=>'please answer all questions']);
        if(collect($answers)->keys()->diff($exam->questions->pluck('id'))->count()>0)
            return response()->json(['error'=>'please answer all this exam questions correctly']);

        $result = $this->correctingAnswers($exam, $answers, $exam->questions);

        $examsResults = $this->getLastFiveResults($exam->subject,$exam);
        return response()->json(array_merge($result, ['last_results' => $examsResults]));
    }


    public function validateAnswers($data)
    {
        $rules=[
            'questions.*'=>'required|numeric',
            'answers.*'=>'required|numeric',
        ];
        return Validator::make($data,$rules);
}
    public function validator($data)
    {
        $rules = [
            'structures.*.chapter' => 'required|numeric',
            'structures.*.count' => 'required|numeric',
            'structures.*.category' => 'required|numeric|min:1|max:3',
            'structures.*.type' => 'required|numeric|min:1|max:2',
        ];
        return Validator::make($data, $rules);
    }

    /**
     * @param $exam
     * @param $answers
     * @param $questions
     * @return array
     */
    public function correctingAnswers($exam, $answers, $questions)
    {
        $sum = 0;
        $mcq = ["true" => 0, 'false' => 0,'total'=>0];
        $true_false_questions = ["true" => 0, 'false' => 0,'total'=>0];
        $questions->each(function ($question) use ($exam, $answers, &$sum, &$mcq, &$true_false_questions) {
//            $question = intval($question);
//            $q = Question::find($question);
            $index=intval($answers[$question->id]);
            $option = $question->options[$index];
            if ($option->correct) {
                if ($question->type->id == 1)
                    $mcq['true']++;
                else
                    $true_false_questions['true']++;
            }
            $sum += $option->correct;
            $this->deletePreviousAnswer($question);
            $exam->answers()->create([
                'question_id' => $question->id,
                'question_option_id' => $option->id,
                'correct' => $option->correct,
                'option_index'=>$index,
            ]);

        });
        $mcq['total']=$exam->questions()->typeMCQ()->count();
        $mcq['false'] = $this->getFalseAnswersCount( $mcq['total'],$mcq['true']);
        $true_false_questions['total']=$exam->questions()->typeTrueOrFalse()->count();
        $true_false_questions['false'] = $this->getFalseAnswersCount($true_false_questions['total'],$true_false_questions['true']);
        $result['total_questions']=$exam->questions->count();
        $result['score']=$sum;
        $result['percent'] = ($result['score'] / $result['total_questions']) * 100;
        return $this->createExamResult($exam, $result, $mcq, $true_false_questions);
    }

    public function getFalseAnswersCount($totalQuestions, $trueQuestions)
    {
        $falseResult = $totalQuestions - $trueQuestions;
        return $falseResult < 0 ? 0 : $falseResult;
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

    /**
     * @param $exam
     * @param $result
     * @param $mcq
     * @param $true_false_questions
     * @return array
     */
    public function createExamResult($exam, $result, $mcq, $true_false_questions)
    {
        $exam->result()->create([
            'marks' => $result['percent'],
            'correct_answers' => $mcq['true'] + $true_false_questions['true'],
            'wrong_answers' => $mcq['false'] + $true_false_questions['false'],
        ]);
        return ['mcq' => $mcq, 'true_false' => $true_false_questions, 'result' => $result];
    }

    /**
     * @param $subject
     * @param $exam
     * @return array
     */
    public function getLastFiveResults($subject,$exam)
    {
        $exams = auth()->user()->student->trainingExams()->subject($subject->id)->where('id','!=',$exam->id)->latest()->take(5)->get();
        return TrainingExamsResultResource::collection($exams)->jsonSerialize();
    }
}
