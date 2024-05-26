<?php

namespace App\Services;

use App\Models\Team;
use App\Repositories\Contracts\DivisionRepositoryContract;
use App\Repositories\Contracts\TeamRepositoryContract;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

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
     * @throws Exception
     */
    public function create(array $data): void
    {
        if (! Auth::user()->hasPermissionTo('create_team')) {
            throw new Exception('You do not have permission to create a team.', 403);
        }

        $divisionId = $data['division_id'] ?? null;
        if ($divisionId) {
            $teamsCountInDivision = $this->countTeamsInDivision($divisionId);
            if ($teamsCountInDivision >= 10) {
                throw new Exception('Division has reached the maximum limit of teams.', 400);
            }
        }

        $this->teamRepository->create($data);
    }

    /**
     * @throws Exception
     */
    public function update(int $id, array $data): void
    {
        if (! Auth::user()->hasPermissionTo('edit_team')) {
            throw new Exception('You do not have permission to edit a team.', 403);
        }

        $team = $this->teamRepository->getById($id);
        if (! $team) {
            throw new Exception('Team not found.', 404);
        }

        $newDivisionId = $data['division_id'] ?? $team->division_id;
        if ($newDivisionId != $team->division_id) {
            $teamsCountInNewDivision = $this->countTeamsInDivision($newDivisionId);
            if ($teamsCountInNewDivision >= 10) {
                throw new Exception('Division has reached the maximum limit of teams.', 400);
            }
        }

        $this->teamRepository->update($id, $data);
    }

    /**
     * @throws Exception
     */
    public function delete(int $id): void
    {
        if (! Auth::user()->hasPermissionTo('delete_team')) {
            throw new Exception('You do not have permission to delete a team.', 403);
        }

        $deleted = $this->teamRepository->delete($id);
        if (! $deleted) {
            throw new Exception('Failed to delete team.', 400);
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
