<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfesorResource;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesorController extends Controller
{
    public function index()
    {
        $profesori = Profesor::paginate(10); // Paginacija po 10 zapisa
        return ProfesorResource::collection($profesori);
    }

    public function show($id)
    {
        $user = Auth::user();

        if ($user->tip_korisnika !== 'profesor') {
            return response()->json(['error' => 'Nemate dozvolu za pristup ovom resursu.'], 403);
        }

        // Učitavanje profesora zajedno sa predmetima
        $profesor = Profesor::with('predmeti')->find($id);

        if (!$profesor) {
            return response()->json(['error' => 'Profesor nije pronađen.'], 404);
        }

        return new ProfesorResource($profesor);
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

        return response()->json([
            'message' => 'Profesor uspesno kreiran.',
            'profesor' => new ProfesorResource($profesor),
        ], 200);
    }

    public function update(Request $request, $id)
        {
            $user = Auth::user();

            // Provera da li je ulogovani korisnik profesor
            if ($user->tip_korisnika !== 'profesor') {
                return response()->json(['error' => 'Nemate dozvolu za ovu akciju.'], 403);
            }

            // Pronalazak profesora po ID-ju iz URL-a
            $profesor = Profesor::find($id);

            // Provera da li profesor postoji
            if (!$profesor) {
                return response()->json(['error' => 'profesor nije pronađen.'], 404);
            }

            // Provera da li profesor ažurira SAMO SVOJ nalog
            if ($profesor->user_id !== $user->id) {
                return response()->json(['error' => 'Ne možete menjati podatke drugog profesora.'], 403);
            }

            // Validacija podataka
            $validated = $request->validate([
                'titula' => 'required|string|max:255',
                'kabinet' => 'required|string|max:255',
                'konsultacije' => 'required|string|max:255',
            ]);

            // Ažuriranje podataka profesora
            $profesor->update($validated);

            return response()->json([
                'message' => 'Podaci uspešno ažurirani.',
                'profesor' => new ProfesorResource($profesor),
            ], 200);
        }



}
