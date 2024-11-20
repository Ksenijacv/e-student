<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OcenaResource extends JsonResource
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
            'ocena' => $this->ocena,
            'datum' => $this->datum,
            'komentar' => $this->komentar,
            'ucenik_id' => $this->ucenik ? $this->ucenik->id : null, // Samo ID učenika
            'predmet_id' => $this->predmet ? $this->predmet->id : null, // Samo ID predmeta
        ];
    }
}