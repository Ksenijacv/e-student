<?php

namespace Database\Seeders;

use App\Models\Roditelj;
use App\Models\Ucenik;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UcenikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roditelj = Roditelj::first(); // Uzmi prvog roditelja iz baze, tako da ce se uzeti onaj kog smo mi napravili

        $ucenikUser = User::factory()->create([
            'email' => 'ucenik@example.com',
            'password' => bcrypt('ucenikpassword'),
            'tip_korisnika' => 'ucenik',
        ]);

        Ucenik::factory()->create([
            'user_id' => $ucenikUser->id,
            'ime' => 'Petar Petrović',
            'razred' => '3',
            'odeljenje' => '3a',
            'roditelj_id' => $roditelj->id,
        ]);
    }
}
