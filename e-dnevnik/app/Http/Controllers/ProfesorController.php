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

    public function store(Request $request)
    {
        // Validacija podataka
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'ime' => 'required|string|max:255',
            'titula' => 'required|string|max:255',
            'kabinet' => 'required|string|max:255',
            'konsultacije' => 'required|string|max:255',
        ]);

        // Kreiranje profesora
        $profesor = Profesor::create([
            'user_id' => $request->user_id,
            'ime' => $request->ime,
            'titula' => $request->titula,
            'kabinet' => $request->kabinet,
            'konsultacije' => $request->konsultacije,
        ]);

        return response()->json(['message' => 'Profesor uspešno kreiran.', 'profesor' => $profesor], 201);
    }



}
