<?php

namespace App\Http\Controllers;

use App\ApiCode;
use App\Models\User as ModelsUser;
use App\Moudels\User;
use Illuminate\Http\Request;

class VerificationControllerss extends Controller {

    public function __construct() {
        $this->middleware('auth:api')->except(['verify']);
    }

 
    public function verify($user_id, Request $request) {
        if (! $request->hasValidSignature()) {
            return $this->respondUnAuthorizedRequest(ApiCode::INVALID_EMAIL_VERIFICATION_URL);
        }

        $user = ModelsUser::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

            return redirect()->to('/');
    }

 
    public function resend() {
        if (auth()->user()->hasVerifiedEmail()) {
            return $this->respondBadRequest(ApiCode::EMAIL_ALREADY_VERIFIED);
        }

        auth()->user()->sendEmailVerificationNotification();

        return   $this->response()->json(["Email verification link sent on your email id"]);
    }
}