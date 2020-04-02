<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamQuestionsResource;
use App\Http\Resources\ExamStructureResource;
use App\Http\Resources\TrainingExamsResultResource;
use App\Subject\Exam;
use App\Subject\Question;
use App\Subject\Subject;
use App\TrainingExam\TrainingExam;
use App\TrainingExam\TrainingExamAnswers;
use Carbon\Carbon;
use http\Env\Response;
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
        $notSolvedExams = TrainingExam::notSolved(auth()->user()->student->id)->get();
        if ($notSolvedExams->count() > 0)
            return response()->json(['error' => 'There is not solved exam', 'exam' => $notSolvedExams->first()->id]);
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
     * @param Subject $subject
     * @param TrainingExam $training
     * @return JsonResponse
     */
    public function show(Subject $subject,TrainingExam $training)
    {
        if (!$training->examined) {
            $questions = ExamQuestionsResource::collection($training->questions)->jsonSerialize();
            return response()->json(['exam' => $training->id, 'questions' => $questions]);
        } else {
         return response()->json(['error'=>'this exam is solved']);
        }
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
        if (is_null($training->result)) {
            $training->structures()->delete();
            $training->questions()->detach($training->questions->pluck('id'));
            $training->delete();
            return response()->json(['message' => 'successfully deleting']);
        } else
            return response()->json(['error' => 'this exam is solved']);

    }

    public function storeAnswers(Request $request, TrainingExam $exam)
    {

        if (!is_null($exam->result))
            return response()->json(['error' => 'this exam is solved']);
        $validator = $this->validateAnswers($request->all());
        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()]);
//        $questions = collect($request->get('questions'));
        $answers = $request->get('answers');
//        dd(count($answers));
//        dd($exam->questions->count());
        if (count($answers) != $exam->questions->count())
            return response()->json(['error' => 'please answer all questions']);
        if (collect($answers)->keys()->diff($exam->questions->pluck('id'))->count() > 0)
            return response()->json(['error' => 'please answer all this exam questions correctly']);

        $result = Exam::correctingAnswers($exam, $answers, $exam->questions,true);

        $examsResults = $this->getLastFiveResults($exam->subject, $exam);
        return response()->json(array_merge($result, ['last_results' => $examsResults]));
    }


    public function validateAnswers($data)
    {
        $rules = [
            'answers'=>'required|array',
            'answers.*' => 'required|numeric',
        ];
        return Validator::make($data, $rules);
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


    public function getLastFiveResults($subject, $exam)
    {
        $exams = auth()->user()->student->trainingExams()->subject($subject->id)->where('id', '!=', $exam->id)->latest()->take(5)->get();
        return TrainingExamsResultResource::collection($exams)->jsonSerialize();
    }
}
