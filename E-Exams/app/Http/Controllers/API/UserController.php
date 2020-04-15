<?php

namespace App\Http\Controllers\API;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Resources\RegistrationRequestsResource;
use App\ImageUtility;
use App\Jobs\SendApprovementEmailJob;
use App\Jobs\SendVerificationEmailJob;
use App\Level;
use App\Mail\ApproveMail;
use App\Student\StudentRegistration;
use App\User;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * login api
     *
     * @param Request $request
     * @return JsonResponse
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
                $success['token'] = $user->createToken('auth_token')->accessToken;
                $success['full_name'] = $user->full_name;
                $success['thumbnail_image'] = $user->profile_image;
                $success['profile_image'] = $user->thumbnail_image;
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
     * @return JsonResponse
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
            'level_id' => ['required', 'numeric', Rule::in(Level::all()->pluck('id')->toArray())],
            'department_id' => ['required', 'numeric', Rule::in(Department::all()->pluck('id')->toArray())],
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
            'level_id' => $data['level_id'],
            'department_id' => $data['level_id'],
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
        SendVerificationEmailJob::dispatch($user)->delay(now()->addMinutes(1));
        $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
//        $success['token'] = $user->createToken('auth_token')->accessToken;
        $success['full_name'] = $user->full_name;
        return $success;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'sometimes|file|image|max:2048',
            'new_password' => 'sometimes|string|min:8',
            'current_password' => 'sometimes|string|min:8',
            'email' => 'sometimes|email|unique:users',
            'current_email' => 'sometimes|email',
        ]);
        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()]);
        if ($request->has('image')) {

            $images = $this->updateImage($request->file('image'));
            return response()->json(array_merge(['success' => true], $images));
        }

        if ($request->has('current_password')
            && $request->has('new_password')) {
            $currentPassword = $request->get('current_password');
            $newPassword = $request->get('new_password');
            if (Hash::check($currentPassword, auth()->user()->password)) {
                auth()->user()->update(['password' => bcrypt($newPassword)]);
                return response()->json(['success' => 'password is updated successfully']);
            } else
                return response()->json(['error' => 'write current password correctly']);
        }
        if ($request->has('current_email')
            && $request->has('email')) {
            $currentEmail = $request->get('current_email');
            $newEmail = $request->get('email');
            if (auth()->user()->email == $currentEmail) {
                auth()->user()->update(['email' => $newEmail]);
                return response()->json(['success' => 'email is updated successfully']);
            } else
                return response()->json(['error' => 'write current email correctly']);
        } else {
            return \response()->json(['error' => 'please enter password or email or upload profile image.']);
        }
    }

    public function updateImage($image)
    {
//        dd(auth()->user()->original_image !== ImageUtility::defaultOriginalImage);
        if (auth()->user()->original_image !== ImageUtility::defaultOriginalImage)
            ImageUtility::deleteImage(auth()->user()->original_image);
        if (auth()->user()->profile_image !== ImageUtility::defaultProfileImage)
            ImageUtility::deleteImage(auth()->user()->profile_image);
        if (auth()->user()->thumbnail_image !== ImageUtility::defaultThumbnailImage)
            ImageUtility::deleteImage(auth()->user()->thumbnail_image);
        $thumbStr = ImageUtility::storeImage($image, '/storage/images/thumbnail/', 15, 15);
        $profileStr = ImageUtility::storeImage($image, '/storage/images/profile/', 64, 64);
        $originalStr = "/storage/" . $image->store('images/original', 'public');
        $user = Auth::user();
        $user->thumbnail_image = $thumbStr;
        $user->profile_image = $profileStr;
        $user->original_image = $originalStr;
        $user->save();
//        $user->update([
//            'thumbnail_image' => $thumbStr,
//            'profile_image' => $profileStr,
//            'original_image' => $originalStr,
//        ]);
//        dd(auth()->user());
        return ['thumb_image' => $thumbStr, 'profile_image' => $profileStr];

    }

    public function getRegistrationRequests()
    {
       $users= User::unapproved()->verified()->get();
        return RegistrationRequestsResource::collection($users);
    }

    public function approveRegistrationRequest(User $user)
    {
//        $user->update(['approved'=>1]);
        $user->approved=1;
        $user->save();
        SendApprovementEmailJob::dispatch("We are happy to approve you successfully.",$user->full_name,$user->email)->delay(now()->addMinutes(1));
        return response()->json(['success'=>true]);
    }
    public function unApproveRegistrationRequest(User $user)
    {
        if($user->approved!=1){
            if(is_null($user->student))
            {
                $user->professor->delete();

            }else{
                $student=$user->student;
                $student->registrations->last()->delete();
                $student->delete();
            }
            SendApprovementEmailJob::dispatch("We are sorry to not approve you.",$user->full_name,$user->email)->delay(now()->addMinutes(1));
            $user->roles()->detach($user->roles);
            $user->delete();
            return response()->json(['success'=>true]);
        }else{
            return \response()->json(['success'=>false,"error"=>"this user is approved"]);
        }

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
