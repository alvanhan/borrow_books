<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 500);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success = null;


        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('auth_token')->accessToken;

            $cookie = cookie('auth_token', $success['token'], 120);
            return $this->sendResponse($success, 'User login successfully.')->withCookie($cookie);
        }
        else{
            return $this->sendError('Not Found.', ['error'=>'Email or Password does not match'], 401);
        }
    }

    function getuser() : JsonResponse {
        $user = Auth::guard('api')->user();
        return $this->sendResponse($user, 'User retrieved successfully.');
    }

    public function logout(Request $request): JsonResponse
    {
        $cookie = \Cookie::forget('auth_token');
        return $this->sendResponse([], 'User logout successfully.')->withCookie($cookie);
    }
}
