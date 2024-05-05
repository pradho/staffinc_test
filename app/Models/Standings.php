<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standings extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'points', 'win', 'lost', 'draw', 'home_goal', 'away_goal', 'number_of_match'];

    public function teams()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
