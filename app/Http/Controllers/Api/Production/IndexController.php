<?php

namespace App\Http\Controllers\Api\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Welcome to Production API Index',
            'module' => 'Production'
        ]);
    }
}
