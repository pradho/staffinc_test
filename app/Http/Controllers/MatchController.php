<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchRequest;
use App\Http\Resources\MatchResource;
use App\Services\MatchService;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    protected $matchService;

    public function __construct(MatchService $matchService)
    {
        $this->matchService = $matchService;
    }

    /**
     * Simpan data pertandingan
     */
    public function store(MatchRequest $request)
    {
        $result = $this->matchService->save($request->validated());

        if ($result['success']) {
            return response()->json($result['match'], 201);
        } else {
            return response()->json(['message' => $result['message']], 400);
        }
    }

    public function matchStatistics()
    {
        $result = $this->matchService->statistics();
        return MatchResource::collection($result);
    }
}
