<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roditelj extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ime',
        'kontakt',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ucenik()
    {
        return $this->hasMany(Ucenik::class, 'roditelj_id');
    }


}
