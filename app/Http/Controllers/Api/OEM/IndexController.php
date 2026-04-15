<?php

namespace App\Http\Controllers\Api\OEM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Welcome to OEM API Index',
            'module' => 'OEM'
        ]);
    }
}
