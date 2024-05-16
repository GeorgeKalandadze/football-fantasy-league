<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository implements Contracts\TeamRepositoryContract
{
    public function getAll(): Collection
    {
        return Team::with('players', 'division', 'country')->get();
    }

    public function create(array $data): Team
    {
        return Team::create($data);
    }

    public function update(int $id, array $data): Team
    {
        $team = Team::findOrFail($id);
        $team->update($data);

        return $team;
    }

    public function delete(int $id): bool
    {
        return Team::destroy($id);
    }

    public function getById(int $id)
    {
        return Team::with('country', 'division', 'players')->find($id);
    }
}
