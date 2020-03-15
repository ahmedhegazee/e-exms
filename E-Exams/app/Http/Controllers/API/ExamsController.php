<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Http\Resources\ExamStructureResource;
use App\Subject\Exam;
use App\Subject\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Subject $subject
     * @return AnonymousResourceCollection
     */
    public function index(Subject $subject)
    {
        return ExamResource::collection($subject->exams);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Subject $subject
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function store(Request $request, Subject $subject)
    {

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }
        $exam = $subject->exams()->create($request->only('start_time', 'end_time', 'exam_time', 'marks'));
        collect($request->get('chapters'))->each(function($structure) use ($exam) {
            $exam->structures()->create([
                'chapter_id'=>$structure['id'],
                'category'=>$structure['category'],
                'questions_count'=>$structure['count'],
            ]);
        });
            return ExamStructureResource::collection($exam->structures);
    }

    /**
     * Display the specified resource.
     *
     * @param Subject $subject
     * @param Exam $exam
     * @return AnonymousResourceCollection
     */
    public function show(Subject $subject, Exam $exam)
    {
        return ExamStructureResource::collection($exam->structures);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Subject $subject
     * @param Exam $exam
     * @return void
     */
    public function update(Request $request, Subject $subject, Exam $exam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Exam $exam
     * @return Response
     */
    public function destroy(Exam $exam)
    {
        //
    }

    public function validator($data)
    {
        $rules = [
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'exam_time' => 'required|string|regex:/^[0][0-8][:][0-5][0-9]$/', //the time must be hh:mm
            'marks' => 'required|numeric',
//            'chapters.*'=>'required|numeric',
//            'questions_count'=>'required|numeric',
//            'category'=>'required|string|regex:/^[A-C]{1}$/|min:1|max:1',
        ];
        return Validator::make($data, $rules);
    }
}
