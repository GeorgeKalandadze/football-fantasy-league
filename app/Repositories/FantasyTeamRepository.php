<?php

namespace App\Repositories;

use App\Models\FantasyTeam;
use App\Repositories\Contracts\FantasyTeamRepositoryContract;

class FantasyTeamRepository implements FantasyTeamRepositoryContract
{
    public function getAll(): array
    {
        return FantasyTeam::with('players')->get()->toArray();
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

    public function getById(int $id): ?FantasyTeam
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
