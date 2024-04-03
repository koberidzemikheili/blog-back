<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequests\LoginRequest;
use App\Http\Requests\AuthRequests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function login(LoginRequest $request):JsonResponse
    {
        $validatedData = $request->validated();
        $remember = $validatedData['remember'];
        unset($validatedData['remember']);
        if(!auth()->attempt($validatedData,$remember)) {
            return response()->json(['message'=>'could not login user']);
        }
        else
        {
            $user = auth()->user();
            $token = $user->createToken('auth_token', ['server:update'], Carbon::now()->addHour());
            return response()->json(['message' => 'User logged in','token'=>$token], 201);
        }
    }
    public function register(RegisterRequest $request):JsonResponse
    {
        $validatedData = $request->validated();
        User::create($validatedData);
        return response()->json(['message'=>'user created successfully']);
    }
}
