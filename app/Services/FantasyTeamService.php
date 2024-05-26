<?php

namespace App\Services;

use App\Models\FantasyTeam;
use App\Repositories\Contracts\FantasyTeamRepositoryContract;
use App\Repositories\Contracts\PlayerRepositoryContract;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FantasyTeamService
{
    public function __construct(
        private readonly FantasyTeamRepositoryContract $fantasyTeamRepository,
        private readonly PlayerRepositoryContract $playerRepository
    ) {
    }

    public function getAllFantasyTeams(): Collection
    {
        return $this->fantasyTeamRepository->getAll();
    }

    public function getFantasyTeamById(int $id): ?FantasyTeam
    {
        return $this->fantasyTeamRepository->getById($id);
    }

    /**
     * @throws Exception
     */
    public function createFantasyTeam(array $data, $user): FantasyTeam
    {
        if ($user->fantasyTeam()->exists()) {
            throw new Exception('User already has a fantasy team.', 400);
        }

        $data['user_id'] = $user->id;
        $initialBalance = 100;
        $totalCost = 0;

        foreach ($data['players'] as $playerId) {
            $player = $this->playerRepository->getById($playerId);
            if ($player) {
                $totalCost += $player->market_price;
            }
        }

        if ($totalCost > $initialBalance) {
            throw new Exception('Total cost of players exceeds the initial team balance.', 400);
        }

        $data['balance'] = $initialBalance - $totalCost;
        $fantasyTeam = $this->fantasyTeamRepository->create($data);

        if (isset($data['players'])) {
            foreach ($data['players'] as $playerId) {
                $this->fantasyTeamRepository->attachPlayer($fantasyTeam->id, $playerId);
            }
        }

        return $fantasyTeam;
    }

    /**
     * @throws Exception
     */
    public function updateFantasyTeam(int $id, array $data, $user): FantasyTeam
    {
        $user = auth()->user();
        $fantasyTeam = $this->fantasyTeamRepository->getById($id);

        if (! $fantasyTeam) {
            throw new Exception('Fantasy team not found.', 404);
        }

        if ($fantasyTeam->user_id !== $user->id) {
            throw new Exception('You are not authorized to update this fantasy team.', 403);
        }

        $initialBalance = $fantasyTeam->balance;
        $newPlayers = $data['players'] ?? [];
        $totalCostNewPlayers = 0;

        foreach ($newPlayers as $playerId) {
            $player = $this->playerRepository->getById($playerId);
            if (! $player) {
                throw new Exception("The selected player $playerId is invalid.", 400);
            }
            $totalCostNewPlayers += $player->market_price;
        }

        $removedPlayerIds = $fantasyTeam->players()->pluck('players.id')->toArray();
        $totalCostRemovedPlayers = $fantasyTeam->players()->whereIn('players.id', $removedPlayerIds)->sum('market_price');
        $updatedBalance = $initialBalance - $totalCostNewPlayers + $totalCostRemovedPlayers;

        if ($updatedBalance < 0) {
            throw new Exception('Updating the team would result in negative balance.', 400);
        }

        DB::beginTransaction();
        try {
            $this->fantasyTeamRepository->update($id, $data);
            $fantasyTeam->players()->sync($newPlayers);
            $fantasyTeam->update(['balance' => $updatedBalance]);
            DB::commit();

            return $fantasyTeam;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Failed to update fantasy team.', 500);
        }
    }

    /**
     * @throws Exception
     */
    public function deleteFantasyTeam(int $id, $user): void
    {
        if (! $user->hasPermissionTo('delete_fantasy_team')) {
            throw new Exception('You do not have permission to delete a fantasy team.', 403);
        }

        $deleted = $this->fantasyTeamRepository->delete($id);
        if (! $deleted) {
            throw new Exception('Failed to delete fantasy team.', 400);
        }
    }
}
