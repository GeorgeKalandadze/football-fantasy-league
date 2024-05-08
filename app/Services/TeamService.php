<?php

namespace App\Services;

use App\Models\Team;
use App\Repositories\Contracts\DivisionRepositoryContract;
use App\Repositories\Contracts\TeamRepositoryContract;

class TeamService
{
    public function __construct(
        protected TeamRepositoryContract $teamRepository,
        protected DivisionRepositoryContract $divisionRepository
    )
    {

    }

    public function getAllTeams(): array
    {
        return $this->teamRepository->getAll();
    }

    public function create(array $data): Team|string
    {
        $divisionId = $data['division_id'] ?? null;
        if ($divisionId) {
            $teamsCountInDivision = $this->countTeamsInDivision($divisionId);
            if ($teamsCountInDivision >= 10) {
                return 'Division has reached the maximum limit of teams.';
            }
        }

        return $this->teamRepository->create($data);
    }

    public function update(int $id, array $data): Team|string|null
    {
        $team = $this->teamRepository->getById($id);
        if (!$team) {
            return null;
        }

        $newDivisionId = $data['division_id'] ?? $team->division_id;
        if ($newDivisionId != $team->division_id) {
            $teamsCountInNewDivision = $this->countTeamsInDivision($newDivisionId);
            if ($teamsCountInNewDivision >= 10) {
                return 'Division has reached the maximum limit of teams.';
            }
        }

        return $this->teamRepository->update($id, $data);
    }


    public function delete(int $id): bool
    {
        return $this->teamRepository->delete($id);
    }

    public function getById(int $id): ?Team
    {
        return $this->teamRepository->getById($id);
    }

    protected function countTeamsInDivision(int $divisionId): int
    {
        $division = $this->divisionRepository->getById($divisionId);
        return $division->teams()->count();
    }
}
