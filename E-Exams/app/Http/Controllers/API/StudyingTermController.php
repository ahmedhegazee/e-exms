<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudyingTermResource;
use App\StudyingTerm;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class StudyingTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return StudyingTermResource::collection(StudyingTerm::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return StudyingTermResource|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()->all()]);
        }
        $check= StudyingTerm::create($request->all());
        return  new StudyingTermResource($check);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StudyingTerm  $studyingTerm
     * @return Response
     */
    public function show(StudyingTerm $studyingTerm)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param StudyingTerm $term
     * @return void
     */
    public function update(Request $request, StudyingTerm $term)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StudyingTerm $term
     * @return void
     */
    public function destroy(StudyingTerm $term)
    {
        //
    }

    public function validator($data)
    {
        $rules=[
            'term'=>'required|string|min:3'
        ];
        return Validator::make($data,$rules);
    }
}
