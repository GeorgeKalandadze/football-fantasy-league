<?php

namespace App\Services;

use App\Models\Player;
use App\Repositories\Contracts\PlayerRepositoryContract;
use App\Repositories\Contracts\TeamRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Exception;

class PlayerService
{
    public function __construct(
        private readonly PlayerRepositoryContract $playerRepository,
        private readonly TeamRepositoryContract $teamRepository
    ) {}

    public function getAllPlayers(): Collection
    {
        return $this->playerRepository->getAll();
    }

    /**
     * @throws Exception
     */
    public function create(array $data): void
    {
        if (!Auth::user()->hasPermissionTo('create_player')) {
            throw new Exception('You do not have permission to create a player.', 403);
        }

        $teamId = $data['team_id'] ?? null;
        if ($teamId) {
            $playersCountInTeam = $this->countPlayersInTeam($teamId);
            if ($playersCountInTeam >= 23) {
                throw new Exception('Team is fully occupied. Please consider adding this player to another team or create the player without a team.', 400);
            }
        }

        $this->playerRepository->create($data);
    }

    /**
     * @throws Exception
     */
    public function update(int $id, array $data): void
    {
        if (!Auth::user()->hasPermissionTo('edit_player')) {
            throw new Exception('You do not have permission to edit a player.', 403);
        }

        $player = $this->playerRepository->getById($id);
        if (!$player) {
            throw new Exception('Player not found.', 404);
        }

        $newTeamId = $data['team_id'] ?? $player->team_id;
        if ($newTeamId && $this->countPlayersInTeam($newTeamId) >= 23) {
            throw new Exception('Team has reached the maximum limit of players.', 400);
        }

        $this->playerRepository->update($id, $data);
    }

    /**
     * @throws Exception
     */
    public function delete(int $id): void
    {
        if (!Auth::user()->hasPermissionTo('delete_player')) {
            throw new Exception('You do not have permission to delete a player.', 403);
        }

        $deleted = $this->playerRepository->delete($id);
        if (!$deleted) {
            throw new Exception('Failed to delete player.', 400);
        }
    }

    /**
     * @throws Exception
     */
    public function getById(int $id): ?Player
    {
        $player = $this->playerRepository->getById($id);
        if (!$player) {
            throw new Exception('Player not found.', 404);
        }
        return $player;
    }

    /**
     * @throws Exception
     */
    protected function countPlayersInTeam(int $teamId): int
    {
        $team = $this->teamRepository->getById($teamId);
        if (! $team) {
            return 0;
        }

        return $team->players()->count();
    }
}
