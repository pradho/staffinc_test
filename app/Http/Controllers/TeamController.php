<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Resources\TeamResource;
use App\Repositories\TeamRepository;

class TeamController extends Controller
{
    protected $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }
    /**
     * Menampilkan data tim
     */
    public function index()
    {
        $teams = $this->teamRepository->get();
        return TeamResource::collection($teams);
    }
}
