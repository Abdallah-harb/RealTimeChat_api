<?php

namespace App\Http\Controllers\Api\Public\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        try {
            $user = User::create($request->validated());
            $token = auth('api')->attempt(["email"=> $request->email ,"password" => $request->password]);
            $user->token = $token;
            return  ResponseHelper::sendResponseSuccess(new AuthResource($user));

        }catch (\Exception $exception){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$exception->getMessage());
        }
    }

    public function login(LoginRequest $request){
        try {
                if(!$token = auth('api')->attempt(['email' => $request->email,"password" => $request->password])){
                    return  ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,"email or password Incorrect");
                }
                $user = User::whereEmail($request->email)->first();
               $user->token = $token;
             return  ResponseHelper::sendResponseSuccess(new AuthResource($user));
        }catch (\Exception $exception){
            return ResponseHelper::sendResponseError([],Response::HTTP_BAD_REQUEST,$exception->getMessage());
        }
    }
}
