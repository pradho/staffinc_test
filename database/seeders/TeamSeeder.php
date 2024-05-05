<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Suka Bola FC',
                'city' => 'Jakarta',
            ],
            [
                'name' => 'Kopi Enak FC',
                'city' => 'Surabaya',
            ],
            [
                'name' => 'Ayam Goreng FC',
                'city' => 'Bandung',
            ],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
