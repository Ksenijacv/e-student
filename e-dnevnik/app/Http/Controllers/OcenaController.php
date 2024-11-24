<?php

namespace App\Http\Controllers;

use App\Http\Resources\OcenaResource;
use App\Models\Ocena;
use Illuminate\Http\Request;

class OcenaController extends Controller
{
    public function index()
    {
        $ocene = Ocena::paginate(10); 
        return OcenaResource::collection($ocene);
    }
}
