<?php

namespace App\Repositories\Contracts;

use App\Models\FantasyTeam;

interface FantasyTeamRepositoryContract
{
    public function getAll(): array;

    public function create(array $data): FantasyTeam;

    public function update(int $id, array $data): FantasyTeam;

    public function delete(int $id): bool;

    public function getById(int $id): ?FantasyTeam;

    public function attachPlayer(int $fantasyTeamId, int $playerId): void;

    public function detachPlayer(int $fantasyTeamId, int $playerId): void;
}
