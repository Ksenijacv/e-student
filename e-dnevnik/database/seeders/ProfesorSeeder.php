<?php

namespace Database\Seeders;

use App\Models\Predmet;
use App\Models\Profesor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //kreiramo usera i njegove podatke
        $profesorUser = User::factory()->create([
            'email' => 'profesor@example.com',
            'password' => bcrypt('profesorpassword'),
            'tip_korisnika' => 'profesor',
        ]);

        //dopunjujemo profesora i povezujemo sa tim nalogom
        $profesor = Profesor::factory()->create([
            'user_id' => $profesorUser->id,
            'ime' => 'Marko Marković',
            'titula' => 'Docent',
        ]);

        //predmet koji predaje taj profesor
        Predmet::factory()->create([
            'naziv' => 'Vajanje',
            'opis' => 'Osnove vajarstva za ucenike',
            'tezina' => 2,
            'profesor_id' => $profesor->id,
        ]);

        Predmet::factory()->create([
            'naziv' => 'Ruski jezik',
            'opis' => 'Ruski jezik A1 nivoa tezine',
            'tezina' => 4,
            'profesor_id' => $profesor->id,
        ]);
    }
}
