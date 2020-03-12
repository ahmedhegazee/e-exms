<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Level;
use App\StudyingPlan;
use App\Subject\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return SubjectResource::collection(Subject::all());
    }

    /**
     * @param Subject $subject
     */
    public function show(Subject $subject)
    {
        return new SubjectResource($subject);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }
        $level = Level::findOrFail($request->get('level_id'));
        $count = $level->departments()->hasDept($request->get('department_id'))->count();
        if ($count > 0) {
            $check = Subject::create($request->all());

//        $check= auth()->user()->getProfessor()->subjects()->create($request->all());
//        return response()->json(['success'=>$check]);
            return new SubjectResource($check);
        } else {
            return response()->json(['success' => false, 'errors' => 'this department is not in this level']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Subject $subject
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Subject $subject)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }
        $check = $subject->update($request->all());
        return new SubjectResource($check);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
    }

    public function getProfessorSubjects()
    {
        $term =StudyingPlan::current(1)->first()->term->id;
        return SubjectResource::collection(auth()->user()->professor->subjects()->currentTerm($term)->get());
    }

    public function getStudentSubjects()
    {
//        $term =StudyingPlan::current(1)->first()->term->id;
       $studentTerm= auth()->user()->student->registrations->last()->term->id;
       $studentDepartment= auth()->user()->student->registrations->last()->department->id;
       $studentLevel= auth()->user()->student->registrations->last()->level->id;
        return SubjectResource::collection(Subject::currentTerm($studentTerm)->level($studentLevel)->department($studentDepartment));
    }

    public function validator($data)
    {
        $rules = [
            'subject_name' => 'required|string|regex:/^[A-Za-z0-9 ]+$/|min:5|max:200',
            'subject_code' => 'required|string|regex:/^[A-Za-z0-9 ]+$/|unique:subjects|min:3|max:10',
            'level_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'professor_id' => 'required|numeric',
            'credit_hours' => 'required|numeric|min:1|max:20|regex:/^[1-9]{1,2}$/'
        ];

        return Validator::make($data, $rules);
    }
}
