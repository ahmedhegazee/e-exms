<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChapterResource;
use App\Subject\Chapter;
use App\Subject\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChaptersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Subject $subject
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Subject $subject)
    {
        return  ChapterResource::collection($subject->chapters);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Subject $subject
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request,Subject $subject)
    {
        $validator= $this->validator($request->all());
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()->all()]);
        }
        $check= $subject->chapters()->create($request->all());
        return  new ChapterResource($check);
//        return response()->json(['success'=>$check]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject\Chapter  $chapter
     * @return ChapterResource
     */
    public function show(Chapter $chapter)
    {
        return  new ChapterResource($chapter);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Subject $subject
     * @param \App\Subject\Chapter $chapter
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,Subject $subject, Chapter $chapter)
    {
        $validator= $this->validator($request->all());
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()->all()]);
        }
        $check= $chapter->update($request->all());
        return  new ChapterResource($check);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chapter $chapter)
    {
        //
    }

    public function validator($data)
    {
        $rules=[
            'chapter_title'=>'required|string|regex:/^[^!@#$%^&*~;?]+$/|min:5|max:200',
        ];

        return Validator::make($data,$rules);
    }
}
