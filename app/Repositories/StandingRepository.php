<?php

namespace App\Repositories;

use App\Models\Standings;

class StandingRepository extends BaseRepository
{
    public function __construct(Standings $standings)
    {
        parent::__construct($standings);
    }

    public function findByTeam($team_id)
    {
        return Standings::firstOrCreate(['team_id' => $team_id]);
    }

    public function getAll()
    {
        return Standings::orderBy('points', 'desc')
            ->orderByRaw('home_goal - away_goal DESC')
            ->orderBy('away_goal', 'desc')
            ->orderBy('number_of_match')
            ->get();
    }
}
