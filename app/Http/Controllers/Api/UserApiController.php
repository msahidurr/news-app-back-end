<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function index(Request $request)
    {
        return UserResource::collection($request->user());
    }
}
