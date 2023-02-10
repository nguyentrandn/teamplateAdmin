<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember') ? true : false;
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            if ($user->status == config('apps.common.status.active')) {
                $success['token'] =  $user->createToken($user->name)->plainTextToken;
                $success['user'] =  $user;

                return $this->sendResponse($success, 'User login successfully.');
            }
            return $this->sendError('Account not active.', ['error' => 'Account not active']);
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    // logout user
    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return $this->sendResponse('', 'Log out success.');
    }

    // Handle a refresh token user to the api. 
    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        
        $success['token'] = $user->createToken($user->name)->plainTextToken;
        return $this->sendResponse($success, 'Refresh token successfully.');
    }

    // change password
    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user = Auth::user();
            //Match The Old Password
            if (Hash::check($request->old_password, $user->password)) {
                User::find($user->id)->update([
                    'password' => Hash::make($request->password)
                ]);
                $success['user'] = $user->name;
                return $this->sendResponse($success, 'Change password successfully.');
            }
            return $this->sendError('Old password not match.', ['error' => 'Old password not match']);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError("Change password fail",['error' => "Change password fail"]);
        }
    }
}
