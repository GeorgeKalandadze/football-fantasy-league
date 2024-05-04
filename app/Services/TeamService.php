<?php

namespace App\Services;

use App\Models\Team;
use App\Repositories\Contracts\TeamRepositoryContract;

class TeamService
{
    public function __construct(protected TeamRepositoryContract $teamRepository)
    {

    }

    public function getAllTeams(): array
    {
        return $this->teamRepository->getAll();
    }

    public function create(array $data): Team
    {
        return $this->teamRepository->create($data);
    }

    public function update(int $id, array $data): Team
    {
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
}
