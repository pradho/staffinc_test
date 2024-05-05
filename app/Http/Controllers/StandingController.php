<?php

namespace App\Http\Controllers;

use App\Http\Resources\StandingResource;
use App\Repositories\StandingRepository;

class StandingController extends Controller
{
    protected $standingRepository;

    public function __construct(StandingRepository $standingRepository)
    {
        $this->standingRepository = $standingRepository;
    }
    /**
     * Menampilkan klasemen
     */
    public function index()
    {
        $standings = $this->standingRepository->get();
        return StandingResource::collection($standings);
    }
}
