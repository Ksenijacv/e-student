<?php

namespace Database\Seeders;

use App\Models\Roditelj;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoditeljSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roditeljUser = User::factory()->create([
            'email' => 'roditelj@example.com',
            'password' => bcrypt('roditeljpassword'),
            'tip_korisnika' => 'roditelj',
        ]);

        Roditelj::factory()->create([
            'user_id' => $roditeljUser->id,
            'ime' => 'Ana Petrović',
            'kontakt' => '0641234567',
        ]);
    }
}
