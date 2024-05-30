<?php

namespace App\Services;

use App\Models\Division;
use App\Repositories\Contracts\DivisionRepositoryContract;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class DivisionService
{
    public function __construct(private readonly DivisionRepositoryContract $divisionRepository)
    {
    }

    public function getAllDivisions(): Collection
    {
        return $this->divisionRepository->getAll();
    }

    public function create(array $data): void
    {
        $this->divisionRepository->create($data);
    }

    /**
     * @throws Exception
     */

    public function update(int $id, array $data): void
    {
        $division = $this->divisionRepository->getById($id);
        if (! $division) {
            throw new Exception('Division not found.', 404);
        }

        $this->divisionRepository->update($id, $data);
    }

    /**
     * @throws Exception
     */

    public function delete(int $id): void
    {
        $deleted = $this->divisionRepository->delete($id);
        if (! $deleted) {
            throw new Exception('Failed to delete division.', 400);
        }
    }

    /**
     * @throws Exception
     */

    public function getById(int $id): ?Division
    {
        $division = $this->divisionRepository->getById($id);
        if (! $division) {
            throw new Exception('Division not found.', 404);
        }

        return $division;
    }
}
