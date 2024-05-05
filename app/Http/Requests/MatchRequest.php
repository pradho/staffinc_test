<?php

namespace App\Http\Requests;

use App\Repositories\MatchRepository;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest as BaseRequest;

class MatchRequest extends BaseRequest
{
    protected $matchRepository;

    public function __construct(MatchRepository $matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|different:home_team_id|exists:teams,id',
            'match_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {

                    $homeTeamId = $this->input('home_team_id');
                    $awayTeamId = $this->input('away_team_id');

                    $previousMatchForHomeTeam = $this->matchRepository->checkPreviousMatchForTeam($homeTeamId, $value);
                    $previousMatchForAwayTeam = $this->matchRepository->checkPreviousMatchForTeam($awayTeamId, $value);

                    if ($previousMatchForHomeTeam && $previousMatchForAwayTeam) {
                        $fail('Tim hanya dapat bermain sekali dalam sehari');
                    }
                },
            ],
            'home_team_goal' => 'nullable|integer|min:0',
            'away_team_goal' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'home_team_id.required' => 'Tim tuan rumah harus dipilih.',
            'home_team_id.exists' => 'Tim tuan rumah tidak valid.',
            'away_team_id.required' => 'Tim tamu harus dipilih.',
            'away_team_id.different' => 'Tim tuan rumah dan tim tamu harus berbeda.',
            'away_team_id.exists' => 'Tim tamu tidak valid.',
            'match_date.required' => 'Tanggal pertandingan harus diisi.',
            'match_date.date' => 'Format tanggal tidak valid.',
            'home_team_goal.integer' => 'Skor tim tuan rumah harus berupa angka.',
            'away_team_goal.integer' => 'Skor tim tamu harus berupa angka.',
            'home_team_goal.min' => 'Skor tim tuan rumah tidak boleh negatif.',
            'away_team_goal.min' => 'Skor tim tamu tidak boleh negatif.',
        ];
    }
}
