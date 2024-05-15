<?php

namespace App\Repositories;

use App\Models\FantasyTeam;
use App\Repositories\Contracts\FantasyTeamRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class FantasyTeamRepository implements FantasyTeamRepositoryContract
{
    public function getAll(): Collection
    {
        return FantasyTeam::with('players')->get();
    }

    public function create(array $data): FantasyTeam
    {
        return FantasyTeam::create($data);
    }

    public function update(int $id, array $data): FantasyTeam
    {
        $fantasyTeam = FantasyTeam::findOrFail($id);
        $fantasyTeam->update($data);

        return $fantasyTeam;
    }

    public function delete(int $id): bool
    {
        return FantasyTeam::destroy($id);
    }

    public function getById(int $id)
    {
        return FantasyTeam::with('players')->find($id);
    }

    public function attachPlayer(int $fantasyTeamId, int $playerId): void
    {
        $fantasyTeam = FantasyTeam::findOrFail($fantasyTeamId);
        $fantasyTeam->players()->attach($playerId);
    }

    public function detachPlayer(int $fantasyTeamId, int $playerId): void
    {
        $fantasyTeam = FantasyTeam::findOrFail($fantasyTeamId);
        $fantasyTeam->players()->detach($playerId);
    }
}
