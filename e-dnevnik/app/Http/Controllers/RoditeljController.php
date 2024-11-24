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
}
