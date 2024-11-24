<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfesorResource;
use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function index()
    {
        $profesori = Profesor::paginate(10); // Paginacija po 10 zapisa
        return ProfesorResource::collection($profesori);
    }
}
