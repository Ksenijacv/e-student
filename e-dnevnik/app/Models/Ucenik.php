<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ucenik extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ime',
        'razred',
        'odeljenje',
        'roditelj_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roditelj()
    {
        return $this->belongsTo(Roditelj::class);
    }

    public function ocene()
    {
        return $this->hasMany(Ocena::class);
    }
}