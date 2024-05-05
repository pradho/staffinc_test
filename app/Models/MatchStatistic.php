<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id',
        'home_team_goal',
        'away_team_goal',
    ];

}
