<?php

namespace App\Http\Controllers\Api\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Welcome to Utility API Index',
            'module' => 'Utility'
        ]);
    }
}
