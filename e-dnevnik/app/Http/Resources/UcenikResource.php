<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UcenikResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ime' => $this->ime,
            'razred' => $this->razred,
            'odeljenje' => $this->odeljenje,
            'roditelj_id' => $this->roditelj ? $this->roditelj->id : null, 
            'ocene' => OcenaResource::collection($this->whenLoaded('ocene')), // Samo kada su ocene učitane
        ];
    }
}
