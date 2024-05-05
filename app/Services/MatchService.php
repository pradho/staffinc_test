<?php
namespace App\Services;

use App\Models\Matches;
use App\Repositories\MatchRepository;
use App\Repositories\StandingRepository;

class MatchService
{
    protected $matchRepository;
    protected $standingRepository;

    public function __construct(MatchRepository $matchRepository, StandingRepository $standingRepository)
    {
        $this->matchRepository = $matchRepository;
        $this->standingRepository = $standingRepository;
    }

    public function statistics()
    {
        return $this->matchRepository->get();
    }

    public function save(array $data)
    {
        $match = $this->matchRepository->save($data);
        $this->updateStandings($match);
        return ['success' => true, 'match' => $match];
    }

//    protected function isValidMatch(array $data)
//    {
//        if (!$this->teamCanPlayOnceADay($data)) {
//            return ['success' => false, 'message' => 'Data pertandingan tidak valid. Tim hanya dapat bermain sekali dalam sehari'];
//        }
//
//        return ['success' => true];
//    }
//
//    protected function teamCanPlayOnceADay(array $data)
//    {
//        $matchDate = $data['match_date'];
//        $homeTeamId = $data['home_team_id'];
//        $awayTeamId = $data['away_team_id'];
//
//        // Periksa apakah tim home atau away telah bertanding pada tanggal yang sama sebelumnya
//        $previousMatchForHomeTeam = $this->matchRepository->checkPreviousMatchForTeam($homeTeamId, $matchDate);
//        $previousMatchForAwayTeam = $this->matchRepository->checkPreviousMatchForTeam($awayTeamId, $matchDate);
//
//        if ($previousMatchForHomeTeam && $previousMatchForAwayTeam) {
//            return false;
//        }
//
//        return true;
//    }

    protected function updateStandings(Matches $match)
    {
        $homeTeamStanding = $this->standingRepository->findByTeam($match->home_team_id);
        $awayTeamStanding = $this->standingRepository->findByTeam($match->away_team_id);

        $homeTeamScore = $match->statistics->home_team_goal;
        $awayTeamScore = $match->statistics->away_team_goal;

        if ($homeTeamScore > $awayTeamScore) {
            $homeTeamStanding->points += 3;
            $homeTeamStanding->win++;
            $awayTeamStanding->lost++;
        } elseif ($homeTeamScore < $awayTeamScore) {
            $awayTeamStanding->points += 3;
            $awayTeamStanding->win++;
            $homeTeamStanding->lost++;
        } else {
            $homeTeamStanding->points += 1;
            $awayTeamStanding->points += 1;
            $homeTeamStanding->draw++;
            $awayTeamStanding->draw++;
        }

        // Update selisih goal
        $homeTeamStanding->home_goal += $homeTeamScore;
        $homeTeamStanding->away_goal += $awayTeamScore;
        $homeTeamStanding->number_of_match++;

        $awayTeamStanding->home_goal += $awayTeamScore;
        $awayTeamStanding->away_goal += $homeTeamScore;
        $awayTeamStanding->number_of_match++;

        // Simpan perubahan klasemen
        $homeTeamStanding->save();
        $awayTeamStanding->save();

        $this->updateRank();
    }

    protected function updateRank()
    {
        $standings = $this->standingRepository->getAll();
        $rank = 1;
        $previousStanding = null;
        foreach ($standings as $standing) {
            if ($previousStanding && $this->shouldIncrementRank($standing, $previousStanding)) {
                $rank++;
            }
            $standing->rank = $rank;
            $standing->save();
            $previousStanding = $standing;
        }
    }

    protected function shouldIncrementRank($currentStanding, $previousStanding)
    {
        if ($currentStanding->points != $previousStanding->points) {
            return true;
        }
        if ($currentStanding->home_goal - $currentStanding->away_goal != $previousStanding->home_goal - $previousStanding->away_goal) {
            return true;
        }
        if ($currentStanding->away_goal != $previousStanding->away_goal) {
            return true;
        }
        if ($currentStanding->number_of_match > $previousStanding->number_of_match) {
            return true;
        }
        return false;
    }
}
