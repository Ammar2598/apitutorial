<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Traits\GeneralTrait;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Admin;

class AuthController extends Controller
{
    //
    use GeneralTrait;
    public function login(Request $request)
    {
        ///validation
        try {
            $rules = [
                "email" => "required",
                "password" => "required"

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            //login

            $credentials = $request->only(['email', 'password']);

            $token = Auth::guard('admin-api')->attempt($credentials);
            // $token = auth('admin-api')->attempt($credentials);

            if (!$token)
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');
            $admin = Auth::guard('admin-api')->user();
            $admin->api_token = $token;

            ////return token
            return $this->returnData('token', $admin, 'logged in successfully !!');
        } catch (Exception $e) {
            return $this->returnError($e . getCode(), $e . getMessage());
        }
    }

    public function logout(Request $request)
    {
        $token = $request->header('auth-token');

        if ($token) {
            try {
                JWTAuth::setToken($token)->invalidate(); //logout
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return $this->returnError('e001', 'something went wrong');
            }

            return $this->returnSuccessMessage('logged out successfully !!');
        } else {
            $this->returnError('e001', 'something went wrong');
        }
    }
}
