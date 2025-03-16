<?php

namespace App\Http\Controllers;

use App\Http\Resources\PredmetResource;
use App\Models\Predmet;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PredmetController extends Controller
{
    public function index()
    {
        $predmeti = Predmet::paginate(10); // Paginacija po 10 zapisa
        return PredmetResource::collection($predmeti);
    }

    public function dostupniPredmeti()
    {
        if (Auth::user()->tip_korisnika !== 'profesor') {
            return response()->json(['error' => 'Nemate dozvolu'], 403);
        }

        $predmeti = Predmet::whereNull('profesor_id')->get();
        return PredmetResource::collection($predmeti);
    }

    public function getMetricsForAdmin()
    {
        if (Auth::user()->tip_korisnika !== 'admin') {
            return response()->json(['error' => 'Nemate dozvolu'], 403);
        }

        $predmeti_po_profesoru = Profesor::withCount('predmeti')->get(['id', 'ime']);
        $ocene_po_predmetu = Predmet::withCount('ocene')->get(['id', 'naziv']);

        return response()->json([
            'predmeti_po_profesoru' => $predmeti_po_profesoru,
            'ocene_po_predmetu' => $ocene_po_predmetu
        ]);
    }


}
