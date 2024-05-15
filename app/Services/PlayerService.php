<?php

namespace App\Services;

use App\Models\Player;
use App\Repositories\Contracts\PlayerRepositoryContract;
use App\Repositories\Contracts\TeamRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PlayerService
{
    public function __construct(
        protected PlayerRepositoryContract $playerRepository,
        protected TeamRepositoryContract $teamRepository
    ) {

    }

    public function getAllPlayers(): Collection
    {
        return $this->playerRepository->getAll();
    }

    public function create(array $data): string
    {
        if (! Auth::user()->hasPermissionTo('create_player')) {
            return 'You do not have permission to create a player.';
        }

        $teamId = $data['team_id'] ?? null;
        if ($teamId) {
            $playersCountInTeam = $this->countPlayersInTeam($teamId);
            if ($playersCountInTeam >= 23) {
                return 'Team is fully occupied. Please consider adding this player to another team or create the player without a team.';
            }
        }

        $this->playerRepository->create($data);

        return 'Player created successfully';
    }

    public function update(int $id, array $data): string
    {
        if (! Auth::user()->hasPermissionTo('edit_player')) {
            return 'You do not have permission to edit a player.';
        }

        $player = $this->playerRepository->getById($id);
        if (! $player) {
            return 'Player not found.';
        }

        $newTeamId = $data['team_id'] ?? $player->team_id;
        if ($newTeamId && $this->countPlayersInTeam($newTeamId) >= 23) {
            return 'Team has reached the maximum limit of players.';
        }

        $this->playerRepository->update($id, $data);

        return 'Player updated successfully.';
    }

    public function delete(int $id): string
    {
        if (! Auth::user()->hasPermissionTo('delete_player')) {
            return 'You do not have permission to delete a player.';
        }

        $deleted = $this->playerRepository->delete($id);
        if (! $deleted) {
            return 'Failed to delete player.';
        }

        return 'Player deleted successfully.';
    }

    public function getById(int $id): ?Player
    {
        return $this->playerRepository->getById($id);
    }

    protected function countPlayersInTeam(int $teamId): int
    {
        $team = $this->teamRepository->getById($teamId);
        if (! $team) {
            return 0;
        }

        return $team->players()->count();
    }
}
