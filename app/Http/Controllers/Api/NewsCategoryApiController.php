<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoryApiController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'data'  => NewsCategory::active()->get() ?? null,
        ], 200);
    }
}
