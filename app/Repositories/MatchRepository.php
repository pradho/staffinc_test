<?php

namespace App\Repositories;

use App\Models\Matches;
use App\Models\MatchStatistic;
use Illuminate\Support\Facades\DB;

class MatchRepository extends BaseRepository
{
    public function __construct(Matches $match)
    {
        parent::__construct($match);
    }

    public function save(array $data)
    {
        try {
            DB::beginTransaction();

            $match = Matches::create([
                'home_team_id' => $data['home_team_id'],
                'away_team_id' => $data['away_team_id'],
                'match_date' => $data['match_date'],
            ]);

            MatchStatistic::create([
                'match_id' => $match->id,
                'home_team_goal' => $data['home_team_goal'],
                'away_team_goal' => $data['away_team_goal'],
            ]);

            DB::commit();
            return $match;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function checkPreviousMatchForTeam($teamId, $matchDate)
    {
        return Matches::where(function($query) use ($teamId) {
            $query->where('home_team_id', $teamId)
                ->orWhere('away_team_id', $teamId);
        })
            ->whereDate('match_date', $matchDate)
            ->exists();
    }
}
