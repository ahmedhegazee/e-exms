<?php

namespace App\Http\Controllers;

use App\Jobs\SendVerificationEmailJob;
use App\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Events\Verified;
class VerificationApiController extends Controller
{
    use VerifiesEmails;

    /**
     * Show the email verification notice.
     *
     */
    public function show()
    {
//
    }

    /**
     * Mark the authenticated user’s email address as verified.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function verify(Request $request)
    {
        $userID = $request['id'];
        $user = User::findOrFail($userID);
        $date = date('Y-m-d g:i:s');
        $user->email_verified_at = $date; // to enable the “email_verified_at field of that user be a current time stamp by mimicing the must verify email feature
        $user->save();
        return response()->json(['success'=>true,'message'=>'Email verified!']);
    }

    /**
     * Resend the email verification notification.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json('User already have verified email!', 422);
// return redirect($this->redirectPath());
        }
        SendVerificationEmailJob::dispatch( $request->user())->delay(now()->addMinutes(3));

//        $request->user()->sendEmailVerificationNotification();
        return response()->json('The notification has been resubmitted');
// return back()->with(‘resent’, true);
    }
}
