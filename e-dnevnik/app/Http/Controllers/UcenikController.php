<?php

namespace App\Http\Controllers;

use App\Http\Resources\UcenikResource;
use App\Models\Ucenik;
use Illuminate\Http\Request;

class UcenikController extends Controller
{
    public function index()
    {
        $ucenici = Ucenik::paginate(10); // Paginacija po 10 zapisa
        return UcenikResource::collection($ucenici);
    }
}
