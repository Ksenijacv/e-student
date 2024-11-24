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

   
        public function store(Request $request)
        {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'ime' => 'required|string|max:255',
                'razred' => 'required|integer|min:1|max:8',
                'odeljenje' => 'required|string|max:255',
                'roditelj_id' => 'nullable|exists:roditelji,id',
            ]);
    
            $ucenik = Ucenik::create([
                'user_id' => $request->user_id,
                'ime' => $request->ime,
                'razred' => $request->razred,
                'odeljenje' => $request->odeljenje,
                'roditelj_id' => $request->roditelj_id,
            ]);
    
            return response()->json(['message' => 'Učenik uspešno kreiran.', 'ucenik' => $ucenik], 201);
        }
    
    
}
