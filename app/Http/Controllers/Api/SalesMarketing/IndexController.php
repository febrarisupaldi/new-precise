<?php

namespace App\Http\Controllers\Api\SalesMarketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Welcome to SalesMarketing API Index',
            'module' => 'SalesMarketing'
        ]);
    }
}
