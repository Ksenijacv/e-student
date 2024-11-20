<?php

namespace Database\Seeders;

use App\Models\Ocena;
use App\Models\Predmet;
use App\Models\Ucenik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OcenaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ucenik = Ucenik::first(); // Uzmi prvog učenika
        $predmeti = Predmet::all(); // Uzmi sve predmete

        foreach ($predmeti as $predmet) {
            Ocena::factory()->create([
                'ucenik_id' => $ucenik->id,
                'predmet_id' => $predmet->id,
                'ocena' => rand(2, 5), // Ocene od 2 do 5
                'datum' => now()->subDays(rand(1, 30)),
                'komentar' => 'Dobro urađeno!',
            ]);
        }
    }
}
