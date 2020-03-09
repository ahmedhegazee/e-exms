<?php

namespace App\Http\Controllers\API;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeptResource;
use App\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Level $level
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return DeptResource::collection(Department::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Level $level
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $validator = $this->validator($request->all());
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()->all()]);
        }
        $check= Department::create($request->all());
//        return response()->json(['success'=>$check]);
        return  new DeptResource($check);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Level $level
     * @param \App\Department $dept
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Department $dept)
    {
        $validator = $this->validator($request->all());
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()->all()]);
        }
        $check= $dept->update($request->all());
        return response()->json(['success'=>$check]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $dept
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $dept)
    {
        //
    }
    public function validator($data)
    {
        $rules = ['department_title' => 'required|string|regex:/^[^!@#$%^&*~;?]+$/|min:5|max:200'];

        return Validator::make($data, $rules);
    }
}
