<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'home_team' => $this->home_team_id,
            'away_team' => $this->away_team_id,
            'schedule' => $this->match_date,
            'statistics' => $this->statistics->only('home_team_goal', 'away_team_goal'),
        ];
    }
}
