<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExamQuestionsResource;
use App\Http\Resources\QuestionResource;
use App\Subject\Exam;
use App\Subject\Subject;
use Carbon\Carbon;
use DateTime;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

class StudentExamsController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @param Exam $exam
     * @return void
     */
    public function store(Request $request, Exam $exam)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     * @throws \Exception
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), ['exam_code' => 'required|string']);
        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()]);
        $exam = Exam::where('exam_code', $request->get('exam_code'))->get();
//        dd($exam);
        if ($exam->count() > 0) {
            $exam = $exam->first();
            $student = auth()->user()->student;
            $dateTime = explode(' ', $exam->start_time);
            $time = explode(':', $dateTime[1]);
            $date = explode('-', $dateTime[0]);
            $d = new DateTime();
            $d->setTime(intval($time[0]), intval($time[1]), intval($time[2]));
            $d->setDate(intval($date[0]), intval($date[1]), intval($date[2]));
            $diff = \Carbon\Carbon::now();
            $count = $student->examResults()->where('exam_id', $exam->id)->get()->count();
            if ($count > 0)
                return response()->json(['error' => 'you have answered this exam early', 'success' => false]);
            else if ($diff > $exam->start_time
                && $diff->diffInDays($d) == 0
                && $diff->diffInHours($d) < intval(explode(':', $exam->exam_time)[0])
                &&!$exam->examined) {
                //TODO : Making attempt here for the student
                $count=$exam->questions->count();
                $randomNumbers=range(0,$count-1);
                shuffle($randomNumbers);
                $questions=[];
                foreach ($randomNumbers as $index){
                    array_push($questions,$exam->questions[$index]);
                }
                $questions = ExamQuestionsResource::collection(collect($questions))->jsonSerialize();
                return response()->json(['exam' => $exam->id, 'questions' => $questions]);
            }else
                return response()->json(['error' => 'you are not allowed to enter this exam in the current time']);
        } else
            return response()->json(['error' => 'this exam is not found']);
        // check the student is allowed to answer this exam in this time
        // return the questions of this exam

    }

    public function storingAnswers(Request $request,Exam $exam)
    {
        //TODO: testing the allowed time and works correct
        $dateTime = explode(' ', $exam->end_time);
        $time = explode(':', $dateTime[1]);
        $date = explode('-', $dateTime[0]);
        $endDate= Carbon::create(intval($date[0]), intval($date[1]), intval($date[2]),intval($time[0]), intval($time[1]), intval($time[2]));
        $endDate->addMinutes(15);
        $date = Carbon::now();

        if($exam->start_time<$date&&$date<$endDate){
            $validator = $this->validateAnswers($request->all());
            if ($validator->fails())
                return response()->json(['errors' => $validator->errors()]);
            $student=auth()->user()->student;
            $results = $student->examResults()->exams([$exam->id])->get();
            if($results->count()>0)
                return \response()->json(['error'=>'you solved this exam early.']);
            $answers = $request->get('answers');
//        dd(count($answers));
//        dd($exam->questions->count());
            if (count($answers) != $exam->questions->count())
                return response()->json(['error' => 'please answer all questions']);
            if (collect($answers)->keys()->diff($exam->questions->pluck('id'))->count() > 0)
                return response()->json(['error' => 'please answer all this exam questions correctly']);

//        $questions = collect($request->get('questions'));

            $result = Exam::correctingAnswers($exam, $answers, $exam->questions);

            return response()->json($result);
    }else
        return response()->json(['error'=>'you are not allowed to submit the answers now']);

    }

    public function validateAnswers($data)
    {
        $rules = [
            'answers'=>'required|array',
            'answers.*' => 'required|numeric',
        ];
        return Validator::make($data, $rules);
    }


}
