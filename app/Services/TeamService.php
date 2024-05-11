<?php

namespace App\Services;

use App\Models\Team;
use App\Repositories\Contracts\DivisionRepositoryContract;
use App\Repositories\Contracts\TeamRepositoryContract;
use Illuminate\Support\Facades\Auth;

class TeamService
{
    public function __construct(
        protected TeamRepositoryContract $teamRepository,
        protected DivisionRepositoryContract $divisionRepository
    ) {

    }

    public function getAllTeams(): array
    {
        return $this->teamRepository->getAll();
    }

    public function create(array $data): string
    {
        if (! Auth::user()->hasPermissionTo('create_team')) {
            return 'You do not have permission to create a team.';
        }

        $divisionId = $data['division_id'] ?? null;
        if ($divisionId) {
            $teamsCountInDivision = $this->countTeamsInDivision($divisionId);
            if ($teamsCountInDivision >= 10) {
                return 'Division has reached the maximum limit of teams.';
            }
        }

        $this->teamRepository->create($data);

        return 'Team created successfully';
    }

    public function update(int $id, array $data): ?string
    {
        if (! Auth::user()->hasPermissionTo('edit_team')) {
            return 'You do not have permission to edit a team.';
        }

        $team = $this->teamRepository->getById($id);
        if (! $team) {
            return null;
        }

        $newDivisionId = $data['division_id'] ?? $team->division_id;
        if ($newDivisionId != $team->division_id) {
            $teamsCountInNewDivision = $this->countTeamsInDivision($newDivisionId);
            if ($teamsCountInNewDivision >= 10) {
                return 'Division has reached the maximum limit of teams.';
            }
        }

        $this->teamRepository->update($id, $data);

        return 'Team updated successfully.';
    }

    public function delete(int $id): bool
    {
        if (! Auth::user()->hasPermissionTo('delete_team')) {
            return 'You do not have permission to delete a team.';
        }

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
