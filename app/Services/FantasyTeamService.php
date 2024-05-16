<?php

namespace App\Services;

use App\Models\FantasyTeam;
use App\Repositories\Contracts\FantasyTeamRepositoryContract;
use App\Repositories\Contracts\PlayerRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
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

    public function createFantasyTeam(array $data): JsonResponse
    {
        $user = auth()->user();
        if ($user->fantasyTeam()->exists()) {
            return response()->json(['message' => 'User already has a fantasy team.'], 400);
        }

        $data['user_id'] = request()->user()->id;
        $initialBalance = 100;
        $totalCost = 0;

        foreach ($data['players'] as $playerId) {
            $player = $this->playerRepository->getById($playerId);
            if ($player) {
                $totalCost += $player->market_price;
            }
        }

        if ($totalCost > $initialBalance) {
            return response()->json(['message' => 'Total cost of players exceeds the initial team balance.'], 400);
        }
        $data['balance'] = $initialBalance - $totalCost;
        $fantasyTeam = $this->fantasyTeamRepository->create($data);
        if (isset($data['players'])) {
            foreach ($data['players'] as $playerId) {
                $this->fantasyTeamRepository->attachPlayer($fantasyTeam->id, $playerId);
            }
        }

        return response()->json(['message' => 'Fantasy team created successfully.'], 201);
    }

    public function updateFantasyTeam(int $id, array $data): JsonResponse
    {
        $user = auth()->user();
        $fantasyTeam = $this->fantasyTeamRepository->getById($id);

        if (! $fantasyTeam) {
            return response()->json(['message' => 'Fantasy team not found.'], 404);
        }

        if ($fantasyTeam->user_id !== $user->id) {
            return response()->json(['message' => 'You are not authorized to update this fantasy team.'], 403);
        }

        $initialBalance = $fantasyTeam->balance;
        $newPlayers = isset($data['players']) ? $data['players'] : [];
        $totalCostNewPlayers = 0;

        foreach ($newPlayers as $playerId) {
            $player = $this->playerRepository->getById($playerId);
            if (! $player) {
                return response()->json(['message' => "The selected player $playerId is invalid."], 400);
            }
            $totalCostNewPlayers += $player->market_price;
        }

        $removedPlayerIds = $fantasyTeam->players()->pluck('players.id')->toArray();
        $totalCostRemovedPlayers = $fantasyTeam->players()->whereIn('players.id', $removedPlayerIds)->sum('market_price');
        $updatedBalance = $initialBalance - $totalCostNewPlayers + $totalCostRemovedPlayers;

        if ($updatedBalance < 0) {
            return response()->json(['message' => 'Updating the team would result in negative balance.'], 400);
        }

        DB::beginTransaction();
        try {
            $this->fantasyTeamRepository->update($id, $data);
            $fantasyTeam->players()->sync($newPlayers);
            $fantasyTeam->update(['balance' => $updatedBalance]);
            DB::commit();

            return response()->json(['message' => 'Fantasy team updated successfully.', 'fantasy_team' => $fantasyTeam]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Failed to update fantasy team.'], 500);
        }
    }

    public function deleteFantasyTeam(int $id): string
    {
        if (! Auth::user()->hasPermissionTo('delete_fantasy_team')) {
            return 'You do not have permission to delete a fantasy team.';
        }

        $deleted = $this->fantasyTeamRepository->delete($id);
        if (! $deleted) {
            return 'Failed to delete fantasy team.';
        }

        return 'Fantasy team deleted successfully.';
    }
}
