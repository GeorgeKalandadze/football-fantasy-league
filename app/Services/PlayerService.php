<?php

// app/Services/PlayerService.php

namespace App\Services;

use App\Exceptions\PlayerException;
use App\Models\Player;
use App\Repositories\Contracts\PlayerRepositoryContract;
use App\Repositories\Contracts\TeamRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class PlayerService
{
    public function __construct(
        private readonly PlayerRepositoryContract $playerRepository,
        private readonly TeamRepositoryContract $teamRepository
    ) {
    }

    public function getAllPlayers(): Collection
    {
        return $this->playerRepository->getAll();
    }

    /**
     * @throws PlayerException
     */
    public function create(array $data): void
    {
        $teamId = $data['team_id'] ?? null;
        if ($teamId && $this->countPlayersInTeam($teamId) >= 23) {
            throw PlayerException::teamFullyOccupied();
        }

        $this->playerRepository->create($data);
    }

    /**
     * @throws PlayerException
     */
    public function update(int $id, array $data): void
    {
        $player = $this->playerRepository->getById($id);
        if (! $player) {
            throw PlayerException::playerNotFound();
        }

        $newTeamId = $data['team_id'] ?? $player->team_id;
        if ($newTeamId && $this->countPlayersInTeam($newTeamId) >= 23) {
            throw PlayerException::teamFullyOccupied();
        }

        $this->playerRepository->update($id, $data);
    }

    /**
     * @throws PlayerException
     */
    public function delete(int $id): void
    {
        $player = $this->playerRepository->getById($id);

        if (! $player) {
            throw PlayerException::playerNotFound();
        }

        $this->playerRepository->delete($id);
    }

    /**
     * @throws PlayerException
     */
    public function getById(int $id): ?Player
    {
        $player = $this->playerRepository->getById($id);
        if (! $player) {
            throw PlayerException::playerNotFound();
        }

        return $player;
    }

    protected function countPlayersInTeam(int $teamId): int
    {
        $team = $this->teamRepository->getById($teamId);

        return $team ? $team->players()->count() : 0;
    }
}
