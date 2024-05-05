<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StandingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->teams->name,
            'city' => $this->teams->city,
            'rank'=> $this->rank,
            'points'=> $this->points,
            'win'=> $this->win,
            'lost'=> $this->lost,
            'draw'=> $this->draw,
            'number_of_match'=> $this->number_of_match,
            'home_goal'=> $this->home_goal,
            'away_goal'=> $this->away_goal
        ];
    }
}
