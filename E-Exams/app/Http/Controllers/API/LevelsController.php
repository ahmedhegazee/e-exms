<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeptResource;
use App\Http\Resources\LevelResource;
use App\Level;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class LevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
//        $levels = Level::all()->map(function ($level) {
//            return [
//                'id' => $level->id,
//                'level' => $level->level_title,
//            ];
//        })->all();
//        return response()->json($levels);
        return LevelResource::collection(Level::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return LevelResource
     */
    public function store(Request $request)
    {
//            App::setLocale($request->get('lang'));

        $validator= $this->validator($request->all());
       if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()->all()]);
       }
       $level= Level::create($request->all());
//        return response()->json(['success'=>$level]);
        return new LevelResource($level);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Level $level
     * @return AnonymousResourceCollection
     */
    public function show(Level $level)
    {
        return DeptResource::collection($level->departments);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Level $level
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Level $level)
    {
        $validator= $this->validator($request->all());
        if($validator->fails()){
            return response()->json(['success'=>false,'errors'=>$validator->errors()->all()]);
        }
        $check= $level->update($request->all());
        return response()->json(['success'=>$check]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Level $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level)
    {

    }

    /**
     * @param Request $request
     * @param Level $level
     * @return AnonymousResourceCollection
     */
    public function addDepartments(Request $request, Level $level)
    {
        $level->departments()->syncWithoutDetaching($request->get('departments'));
        return DeptResource::collection($level->departments);
    }
    public function getDepartments( Level $level)
    {
        return DeptResource::collection($level->departments);
    }
    public function validator($data)
    {
        $rules = ['level_title' => 'required|string|regex:/^[^!@#$%^&*~;?]+$/|min:5|max:200'];

        return Validator::make($data, $rules);
    }
}
