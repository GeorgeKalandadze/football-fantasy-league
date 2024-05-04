<?php

namespace App\Repositories;

use App\Models\Team;

class TeamRepository implements Contracts\TeamRepositoryContract
{

    public function getAll(): array
    {
        return Team::all()->toArray();
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
        return Team::find($id);
    }
}
