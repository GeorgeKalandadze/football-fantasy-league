<?php

namespace App\Services;

use App\Models\Player;
use App\Repositories\Contracts\PlayerRepositoryContract;
use App\Repositories\Contracts\TeamRepositoryContract;

class PlayerService
{
    public function __construct(
        protected PlayerRepositoryContract $playerRepository,
        protected TeamRepositoryContract $teamRepository
    )
    {

    }

    public function getAllPlayers(): array
    {
        return $this->playerRepository->getAll();
    }

    public function create(array $data)
    {
        $teamId = $data['team_id'] ?? null;
        if ($teamId) {
            $playersCountInTeam = $this->countPlayersInTeam($teamId);
            if ($playersCountInTeam >= 23) {
                return 'Team is fully occupied. Please consider adding this player to another team or create the player without a team.';
            }
        }

        return $this->playerRepository->create($data);
    }

    public function update(int $id, array $data): Player
    {
        $teamId = $data['team_id'] ?? null;
        if ($teamId) {
            $playersCountInTeam = $this->countPlayersInTeam($teamId);
            if ($playersCountInTeam >= 23) {
                return 'Team is fully occupied. Please consider adding this player to another team or create the player without a team.';
            }
        }

        return $this->playerRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->playerRepository->delete($id);
    }

    public function getById(int $id): ?Player
    {
        return $this->playerRepository->getById($id);
    }

    protected function countPlayersInTeam(int $teamId): int
    {
        $team = $this->teamRepository->getById($teamId);
        return $team->players()->count();
    }
}

