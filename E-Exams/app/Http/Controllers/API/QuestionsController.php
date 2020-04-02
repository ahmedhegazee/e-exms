<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Subject\Chapter;
use App\Subject\Question;
use App\Subject\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use function foo\func;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Subject $subject
     * @param Chapter $chapter
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(Request $request,Subject $subject,Chapter $chapter)
    {
        //type =>1 for MCQ , 2 for T|F
        //category A, B, C
        $validator=$this->validateFilters($request->all());
        if($validator->fails())
            return response()->json(['errors'=>$validator->errors()->all()]);
        if($request->has('category')&&$request->has('type')){
            $type=intval($request->get('type'));
            $category=intval($request->get('category'));
            return QuestionResource::collection($chapter->questions()->public()->questionType($type)->questionCategory($category)->paginate(20));
        }
        else if($request->has('type')){
            $type=intval($request->get('type'));
//            dd($chapter->questions()->questionType($type)->paginate(20));
            return QuestionResource::collection($chapter->questions()->public()->questionType($type)->paginate(20));
        }
        else{
            return response()->json(['error'=>'please select type']);
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Subject $subject
     * @param Chapter $chapter
     * @return QuestionResource|JsonResponse
     */
    public function store(Request $request,Subject $subject,Chapter $chapter)
    {
        $validator= $this->validator($request->all());
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()->all()]);
        }
//        $check= auth()->user()->getProfessor()->subjects()->create($request->all());
        $question=$chapter->questions()->create($request->only('question_content','category','question_type_id','correct_answer','is_public'));
        collect($request->get('options'))->each(function($option) use ($question) {
            $question->options()->create(['option_content'=>$option]);
        });
        $correct=intval($request->get('correct'));
        $question->options[$correct]->update(['correct'=>1]);
        return  new QuestionResource($question);
//        $check
//        return response()->json(['success'=>$check]);
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return QuestionResource
     */
    public function show(Question $question)
    {
        return  new QuestionResource($question);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Subject $subject
     * @param Chapter $chapter
     * @param Question $question
     * @return void
     */
    public function update(Request $request,Subject $subject,Chapter $chapter, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return Response
     */
    public function destroy(Question $question)
    {
        //
    }
    public function validator($data)
    {
        $rules=[
            'question_content'=>'required|string|min:5|max:200',
            'category'=>'required|string|regex:/^[A-C]{1}$/|min:1|max:1',
            'options.*'=>'required|string|min:5|max:200',
            'correct_answer' => 'required|numeric|min:0|max:3',
            'question_type_id' => 'required|numeric',
            'is_public'=>'required|numeric|min:0|max:1',
        ];
        $messages=[
            'question_content.required'=>'The question field is required',
            'question_content.min'=>'The question field must have at least 5 characters',
            'question_content.max'=>'The question field must not longer than 200 characters',
            'category.required'=>'The category field is required',
            'category.min'=>'The subject code field must be 1 character',
            'category.max'=>'The subject code field must be 1 character',
            'category.regex'=>'The subject code field must be A or B or C',
            'correct.required'=>'The correct answer field is required',
            'correct.numeric'=>'The correct answer field must be numbers',
            'options.*.required'=>'This option field is required',
            'options.*.min'=>'This option field must have at least 5 characters',
            'options.*.max'=>'This option field must not longer than 200 characters',
        ];
        return Validator::make($data,$rules,$messages);
    }

    public function validateFilters($data)
    {
        $rules=[
            'type'=>'sometimes|numeric|min:1|max:2',
            'category'=>'sometimes|numeric|min:1|max:3',
        ];

        return Validator::make($data,$rules);
    }
}
