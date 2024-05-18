<?php

namespace App\Services;

use App\Models\Division;
use App\Repositories\Contracts\DivisionRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Exception;

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
        if (!Auth::user()->hasPermissionTo('create_division')) {
            throw new Exception('You do not have permission to create a division.', 403);
        }

        $this->divisionRepository->create($data);
    }

    public function update(int $id, array $data): void
    {
        if (!Auth::user()->hasPermissionTo('edit_division')) {
            throw new Exception('You do not have permission to edit a division.', 403);
        }

        $division = $this->divisionRepository->getById($id);
        if (!$division) {
            throw new Exception('Division not found.', 404);
        }

        $this->divisionRepository->update($id, $data);
    }

    public function delete(int $id): void
    {
        if (!Auth::user()->hasPermissionTo('delete_division')) {
            throw new Exception('You do not have permission to delete a division.', 403);
        }

        $deleted = $this->divisionRepository->delete($id);
        if (!$deleted) {
            throw new Exception('Failed to delete division.', 400);
        }
    }

    public function getById(int $id): ?Division
    {
        $division = $this->divisionRepository->getById($id);
        if (!$division) {
            throw new Exception('Division not found.', 404);
        }
        return $division;
    }
}
