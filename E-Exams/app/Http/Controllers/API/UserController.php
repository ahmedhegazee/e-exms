<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendVerificationEmailJob;
use App\Student\StudentRegistration;
use App\StudyingPlan;
use App\StudyingTerm;
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
    public function login(Request $request)
    {
        app()->setLocale($request->get('lang'));
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 401);
        } else if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();

            if ($user->email_verified_at == NULL) {
                return response()->json(['error' => 'Please Verify Email'], 401);

            } else if ($user->approved == 0) {
                return response()->json(['error' => 'You are not approved yet.'], 401);
            } else {
                $success['token'] = $user->createToken('MyApp')->accessToken;
                return response()->json(['success' => $success], $this->successStatus);
            }

        } else {
            return response()->json(['error' => __('auth.failed')], 401);
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
        $success = [];
        $validator = $this->validateUserData($request->all());
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 401);
        }
        if ($request->get('user_type') == 1) {
            $validator = $this->validateStudentData($request->all());
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all()], 401);
            }
            $user = $this->createUser($request->all());
            $this->createStudent($request->all(), $user);
            $success = $this->successAction($user);
        } else {
            $validator = $this->validateProfessorData($request->all());
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all()], 401);
            }
            $user = $this->createUser($request->all());
            $this->createProfessor($request->all(), $user);
            $success = $this->successAction($user);
        }

        return response()->json(['success' => $success], $this->successStatus);
    }

    public function validateUserData($data)
    {
        $rules = [
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*#?&]{8,}$/|min:8',
            'c_password' => 'required|same:password',
            'user_type' => 'required|numeric|regex:/^[1-2]{1}$/|' // 1 for student , 2 for professor
        ];
        return Validator::make($data, $rules);
    }

    public function validateStudentData($data)
    {
        $rules = [
            'academic_id' => 'required|string|regex:/^[0-9]{16}$/|unique:students',
            'level_id' => 'required|numeric',
            'department_id' => 'required|numeric',
        ];

        return Validator::make($data, $rules);
    }

    public function validateProfessorData($data)
    {
        $rules = [
            'department_id' => 'required|numeric',
        ];

        return Validator::make($data, $rules);
    }

    public function createUser($data)
    {

        $data['password'] = bcrypt($data['password']);
        return User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);
    }

    public function createStudent($data, User $user)
    {
        $user->roles()->attach(1);
        $student = $user->student()->create($data);
        $student->registrations()->create([
            'level_id' => $data->get('level_id'),
            'department_id' => $data->get('level_id'),
            'term' => 1,
        ]);
    }

    public function createProfessor($data, User $user)
    {
        $user->roles()->attach([2, 3]);
        $user->professor()->create($data);
    }

    public function successAction($user)
    {
//        $user->sendApiEmailVerificationNotification();
        SendVerificationEmailJob::dispatch($user)->delay(now()->addMinutes(3));
        $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
        $success['token'] = $user->createToken('auth_token')->accessToken;
        $success['full_name'] = $user->full_name;
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
