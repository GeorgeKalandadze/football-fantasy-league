<?php

namespace App\Services;

use App\Models\Division;
use App\Repositories\Contracts\DivisionRepositoryContract;

class DivisionService
{
    public function __construct(protected DivisionRepositoryContract $divisionRepository)
    {

    }

    public function getAllDivisions(): array
    {
        return $this->divisionRepository->getAll();
    }

    public function create(array $data): Division
    {
        return $this->divisionRepository->create($data);
    }

    public function update(int $id, array $data): Division
    {
        return $this->divisionRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->divisionRepository->delete($id);
    }

    public function getById(int $id): ?Division
    {
        return $this->divisionRepository->getById($id);
    }
}
