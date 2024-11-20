<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UcenikController extends Controller
{
    public function helloWorld()
    {
        return response()->json([
            'message' => 'Hello, world! Ovo radi!'
        ]);
    }
}
