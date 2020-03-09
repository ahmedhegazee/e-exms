<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * login api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        app()->setLocale($request->get('lang'));
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()], 401);
        }else  if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>__('auth.failed')], 401);
        }
    }

    /**
     * Register api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $success=[];
        $validator = $this->validateUserData($request->all());
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()], 401);
        }
        if($request->get('user_type')==1){
            $validator = $this->validateStudentData($request->all());
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()->all()], 401);
            }
            $user=$this->createUser($request->all());
            $this->createStudent($request->all(),$user);
            $success=$this->successAction($user);
        }
        else {
            $validator = $this->validateProfessorData($request->all());
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()->all()], 401);
            }
            $user=$this->createUser($request->all());
            $this->createProfessor($request->all(),$user);
            $success=$this->successAction($user);
        }

        return response()->json(['success'=>$success], $this-> successStatus);
    }

    public function validateUserData($data)
    {
        $rules=[
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'user_type'=>'required|numeric' // 1 for student , 2 for professor
        ];
        return Validator::make($data,$rules);
    }
    public function validateStudentData($data)
    {
        $rules=[
            'academic_id' => 'required|string|regex:/^[0-9]{16}$/|unique:students',
            'level_id' => 'required|numeric',
            'department_id' => 'required|numeric',
        ];
        $messages=[
            'academic_id.regex'=>'The academic id must be 16 digits',
            'academic_id.required'=>'The academic id field is required',
            'academic_id.unique'=>'The academic id must be unique',
        ];
        return Validator::make($data,$rules,$messages);
    }
    public function validateProfessorData($data)
    {
        $rules=[
            'department_id' => 'required|numeric',
        ];

        return Validator::make($data,$rules);
    }

    public function createUser($data)
    {

        $data['password'] = bcrypt($data['password']);
        return User::create([
            'full_name'=>$data['full_name'],
            'email'=>$data['email'],
            'password'=>$data['password']
        ]);
    }

    public function createStudent($data,User $user)
    {
     $user->student()->create($data) ;
    }
    public function createProfessor($data,User $user)
    {
     $user->professor()->create($data) ;
    }

    public function successAction($user)
    {
        $success['token'] =  $user->createToken('auth_token')-> accessToken;
        $success['full_name'] =  $user->full_name;
        return $success;
    }
//    /**
//     * details api
//     *
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function details()
//    {
//        $user = Auth::user();
//        return response()->json(['success' => $user], $this-> successStatus);
//    }

}
