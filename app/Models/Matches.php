<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'match_date',
    ];

    public function statistics()
    {
        return $this->hasOne(MatchStatistic::class, 'match_id');
    }

    public function teams()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
