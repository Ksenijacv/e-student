<?php

namespace App\Http\Controllers;

use App\Http\Resources\OcenaResource;
use App\Models\Ocena;
use App\Models\Ucenik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OcenaController extends Controller
{
    public function index()
    {
        $ocene = Ocena::paginate(10); 
        return OcenaResource::collection($ocene);
    }

    public function vratiMojeOcene()
    {
        $user = Auth::user();

        // Provera da li je korisnik ulogovan i da li je ucenik
        if (!$user || $user->tip_korisnika !== 'ucenik') {
            return response()->json(['error' => 'Nemate dozvolu za ovu akciju.'], 403);
        }

        // Pronalazak ucenika na osnovu user_id
        $ucenik = Ucenik::where('user_id', $user->id)->first();

        if (!$ucenik) {
            return response()->json(['error' => 'Učenik nije pronađen.'], 404);
        }

        // Dohvatanje svih ocena koje pripadaju učeniku
        $ocene = Ocena::with(['predmet', 'ucenik'])->where('ucenik_id', $ucenik->id)->get();

        // Vraćamo resurs kroz kolekciju
        return OcenaResource::collection($ocene);
    }
}
