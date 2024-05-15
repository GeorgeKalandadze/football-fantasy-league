<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository implements Contracts\TeamRepositoryContract
{
    public function getAll(): Collection
    {
        return Team::with('players','division','country')->get();
    }

    public function create(array $data)
    {
        return Team::create($data);
    }

    public function update(int $id, array $data)
    {
        $player = Team::findOrFail($id);
        $player->update($data);

        return $player;
    }

    public function delete(int $id)
    {
        return Team::destroy($id);
    }

    public function getById(int $id)
    {
        return Team::with('country', 'division', 'players')->find($id);
    }
}
