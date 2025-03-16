<?php

namespace App\Http\Controllers;

use App\Http\Resources\PredmetResource;
use App\Models\Predmet;
use Illuminate\Http\Request;

class PredmetController extends Controller
{
    public function index()
    {
        $predmeti = Predmet::paginate(10); // Paginacija po 10 zapisa
        return PredmetResource::collection($predmeti);
    }

    public function dostupniPredmeti()
    {
        $predmeti = Predmet::whereNull('profesor_id')->get();
        return PredmetResource::collection($predmeti);
    }


}
