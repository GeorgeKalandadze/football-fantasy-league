<?php

namespace App\Services;

use App\Exceptions\FantasyTeamException;
use App\Models\FantasyTeam;
use App\Repositories\Contracts\FantasyTeamRepositoryContract;
use App\Repositories\Contracts\PlayerRepositoryContract;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FantasyTeamService
{
    protected FantasyTeamRepositoryContract $fantasyTeamRepository;

    protected PlayerRepositoryContract $playerRepository;

    public function __construct(
        FantasyTeamRepositoryContract $fantasyTeamRepository,
        PlayerRepositoryContract $playerRepository
    ) {
        $this->fantasyTeamRepository = $fantasyTeamRepository;
        $this->playerRepository = $playerRepository;
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
     * @throws FantasyTeamException
     */
    public function createFantasyTeam(array $data, $user): FantasyTeam
    {
        if ($user->fantasyTeam()->exists()) {
            throw FantasyTeamException::userAlreadyHasTeam();
        }

        $initialBalance = 100;
        $totalCost = 0;

        foreach ($data['players'] as $playerId) {
            $player = $this->playerRepository->getById($playerId);
            if ($player) {
                $totalCost += $player->market_price;
            }
        }

        if ($totalCost > $initialBalance) {
            throw FantasyTeamException::totalCostExceedsBalance();
        }

        $data['user_id'] = $user->id;
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
     * @throws FantasyTeamException
     */
    public function updateFantasyTeam(int $id, array $data, $user): FantasyTeam
    {
        $fantasyTeam = $this->fantasyTeamRepository->getById($id);

        if (! $fantasyTeam) {
            throw FantasyTeamException::fantasyTeamNotFound();
        }

        if ($fantasyTeam->user_id !== $user->id) {
            throw FantasyTeamException::unauthorizedToUpdateTeam();
        }

        $initialBalance = $fantasyTeam->balance;
        $newPlayers = $data['players'] ?? [];
        $totalCostNewPlayers = 0;

        foreach ($newPlayers as $playerId) {
            $player = $this->playerRepository->getById($playerId);
            if (! $player) {
                throw FantasyTeamException::invalidPlayerSelected($playerId);
            }
            $totalCostNewPlayers += $player->market_price;
        }

        $removedPlayerIds = $fantasyTeam->players()->pluck('players.id')->toArray();
        $totalCostRemovedPlayers = $fantasyTeam->players()->whereIn('players.id', $removedPlayerIds)->sum('market_price');
        $updatedBalance = $initialBalance - $totalCostNewPlayers + $totalCostRemovedPlayers;

        if ($updatedBalance < 0) {
            throw FantasyTeamException::negativeBalance();
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
            throw FantasyTeamException::failedToUpdateTeam();
        }
    }

    /**
     * @throws FantasyTeamException
     */
    public function deleteFantasyTeam(int $id): void
    {
        $deleted = $this->fantasyTeamRepository->delete($id);
        if (! $deleted) {
            throw FantasyTeamException::failedToDeleteTeam();
        }
    }
}
