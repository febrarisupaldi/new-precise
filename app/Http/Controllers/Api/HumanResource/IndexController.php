<?php

namespace App\Http\Controllers\Api\HumanResource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Welcome to HumanResource API Index',
            'module' => 'HumanResource'
        ]);
    }
}
