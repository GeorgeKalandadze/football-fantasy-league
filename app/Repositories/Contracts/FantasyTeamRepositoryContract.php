<?php

namespace App\Repositories\Contracts;

use App\Models\FantasyTeam;
use Illuminate\Database\Eloquent\Collection;

interface FantasyTeamRepositoryContract
{
    public function getAll(): Collection;

    public function create(array $data): FantasyTeam;

    public function update(int $id, array $data): FantasyTeam;

    public function delete(int $id): bool;

    public function getById(int $id);

    public function attachPlayer(int $fantasyTeamId, int $playerId): void;

    public function detachPlayer(int $fantasyTeamId, int $playerId): void;
}
