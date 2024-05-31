<?php

namespace App\Services;

use App\Exceptions\TeamException;
use App\Models\Team;
use App\Repositories\Contracts\DivisionRepositoryContract;
use App\Repositories\Contracts\TeamRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class TeamService
{
    protected TeamRepositoryContract $teamRepository;

    protected DivisionRepositoryContract $divisionRepository;

    public function __construct(
        TeamRepositoryContract $teamRepository,
        DivisionRepositoryContract $divisionRepository
    ) {
        $this->teamRepository = $teamRepository;
        $this->divisionRepository = $divisionRepository;
    }

    public function getAllTeams(): Collection
    {
        return $this->teamRepository->getAll();
    }

    /**
     * @throws TeamException
     */
    public function create(array $data): void
    {
        $divisionId = $data['division_id'] ?? null;
        if ($divisionId) {
            $teamsCountInDivision = $this->countTeamsInDivision($divisionId);
            if ($teamsCountInDivision >= 10) {
                throw TeamException::divisionMaxTeamsReached();
            }
        }

        $this->teamRepository->create($data);
    }

    /**
     * @throws TeamException
     */
    public function update(int $id, array $data): void
    {
        $team = $this->teamRepository->getById($id);
        if (! $team) {
            throw TeamException::teamNotFound();
        }

        $newDivisionId = $data['division_id'] ?? $team->division_id;
        if ($newDivisionId != $team->division_id) {
            $teamsCountInNewDivision = $this->countTeamsInDivision($newDivisionId);
            if ($teamsCountInNewDivision >= 10) {
                throw TeamException::divisionMaxTeamsReached();
            }
        }

        $this->teamRepository->update($id, $data);
    }

    /**
     * @throws TeamException
     */
    public function delete(int $id): void
    {
        $deleted = $this->teamRepository->delete($id);
        if (! $deleted) {
            throw TeamException::failedToDeleteTeam();
        }
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
