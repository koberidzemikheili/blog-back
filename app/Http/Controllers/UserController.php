<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userInformation(): UserResource
    {
        $user = auth()->user();
        return new UserResource($user);
    }
}
