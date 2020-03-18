<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExamStructureResource;
use App\Subject\Subject;
use App\TrainingExam\TrainingExam;
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
    public function store(Request $request,Subject $subject)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }
       $exam= auth()->user()->student->trainingExams()->create([
            'subject_id'=>$subject->id,
        ]);
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
     * @param  \App\TrainingExam\TrainingExam  $trainingExam
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
     * @param  \App\TrainingExam\TrainingExam  $trainingExam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingExam $trainingExam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TrainingExam\TrainingExam  $trainingExam
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingExam $trainingExam)
    {
        //
    }
    public function validator($data)
    {
        $rules = [
            'chapters.*.id'=>'required|numeric',
            'chapters.*.count'=>'required|numeric',
            'chapters.*.category'=>'required|string|regex:/^[A-C]{1}$/|min:1|max:1',
        ];
        return Validator::make($data, $rules);
    }
}
