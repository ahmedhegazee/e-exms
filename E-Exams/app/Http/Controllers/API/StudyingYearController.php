<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudyingTermResource;
use App\Http\Resources\StudyingYearResource;
use App\StudyingTerm;
use App\StudyingYear;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

class StudyingYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return StudyingYearResource::collection(StudyingYear::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return StudyingYearResource|JsonResponse
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()->all()]);
        }
        $check= StudyingYear::create($request->all());
        return  new StudyingYearResource($check);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StudyingYear  $studyingYear
     * @return \Illuminate\Http\Response
     */
    public function show(StudyingYear $studyingYear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\StudyingYear  $studyingYear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudyingYear $studyingYear)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudyingYear  $studyingYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudyingYear $studyingYear)
    {
        //
    }
    public function validator($data)
    {
        $rules=[
            'year'=>'required|string|min:3'
        ];
        return Validator::make($data,$rules);
    }

    /**
     * @param Request $request
     * @param StudyingYear $year
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function addTerms(Request $request, StudyingYear $year)
    {
        $validator = $this->termsValidator($request->all());
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()->all()]);
        }
        $year->terms()->syncWithoutDetaching($request->get('terms'));
        return StudyingTermResource::collection($year->terms);
    }
    public function getTerms( StudyingYear $year)
    {
        return StudyingTermResource::collection($year->terms);
    }

    /**
     * @param Request $request
     * @param StudyingYear $year
     * @param StudyingTerm $term
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function updateTerm(Request$request, StudyingYear $year, StudyingTerm $term)
    {
        $validator = $this->updateValidator($request->all());
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()->all()]);
        }
        if(intval($request->get('is_available'))==1){
            $availableTerms=$year->terms->availableRegistration(1)->count();
            if($availableTerms>0)
                return response()->json(['success'=>false,'errors'=>['The student can register for a studying term already.You can\'t make two  terms for students registration']]);
        }
        if(intval($request->get('is_current'))==1){
            $currentTerms=$year->terms->currentTerm(1)->count();
            if($currentTerms>0)
                return response()->json(['success'=>false,'errors'=>['There is a current term already.You can\'t make two current terms ']]);
        }
        $term->update($request->all());
        return StudyingTermResource::collection($term);
    }

    public function termsValidator($data)
    {
        $rules=[
            'terms.*'=>'numeric'
        ];
        return Validator::make($data,$rules);
    }
    public function updateValidator($data)
    {
        $rules=[
            'is_ended'=>'numeric',
            'is_current'=>'numeric',
            'is_available'=>'numeric',
        ];
        return Validator::make($data,$rules);
    }
}
