<?php

namespace App\Http\Requests;

use App\Models\Player;
use Illuminate\Foundation\Http\FormRequest;

class FantasyTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'players' => 'required|array|min:8',
            'players.*' => 'exists:players,id',
        ];
    }

    protected function prepareForValidation()
    {
        $players = Player::whereIn('id', $this->players)->get();

        $positionsCount = [
            'Goalkeeper' => 0,
            'Defender' => 0,
            'Midfielder' => 0,
            'Forward' => 0,
        ];

        foreach ($players as $player) {
            $positionName = $player->position->name;
            if (isset($positionsCount[$positionName])) {
                $positionsCount[$positionName]++;
            }
        }

        $this->merge(['positions_count' => $positionsCount]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $positionsCount = $this->positions_count;

            if ($positionsCount['Goalkeeper'] < 1) {
                $validator->errors()->add('players', 'A fantasy team must have at least 1 goalkeeper.');
            }

            if ($positionsCount['Defender'] < 2) {
                $validator->errors()->add('players', 'A fantasy team must have at least 2 defenders.');
            }

            if ($positionsCount['Midfielder'] < 3) {
                $validator->errors()->add('players', 'A fantasy team must have at least 3 midfielders.');
            }

            if ($positionsCount['Forward'] < 2) {
                $validator->errors()->add('players', 'A fantasy team must have at least 2 forwards.');
            }
        });
    }
}
