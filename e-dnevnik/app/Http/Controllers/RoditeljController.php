<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoditeljResource;
use App\Models\Roditelj;
use Illuminate\Http\Request;

class RoditeljController extends Controller
{
    public function index()
    {
        $roditelji = Roditelj::paginate(10); // Paginacija po 10 zapisa
        return RoditeljResource::collection($roditelji);
    }

        public function store(Request $request)
        {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'ime' => 'required|string|max:255',
                'kontakt' => 'required|string|max:20',
            ]);
    
            $roditelj = Roditelj::create([
                'user_id' => $request->user_id,
                'ime' => $request->ime,
                'kontakt' => $request->kontakt,
            ]);
    
            return response()->json(['message' => 'Roditelj uspešno kreiran.', 'roditelj' => $roditelj], 201);
        }
    
    
}
