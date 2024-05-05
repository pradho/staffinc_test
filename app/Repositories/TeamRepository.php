<?php

namespace App\Repositories;

use App\Models\Team;

class TeamRepository extends BaseRepository
{
    public function __construct(Team $team)
    {
        parent::__construct($team);
    }
}
