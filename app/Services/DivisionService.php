<?php

namespace App\Services;

use App\Models\Division;
use App\Repositories\Contracts\DivisionRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class DivisionService
{
    public function __construct(private readonly DivisionRepositoryContract $divisionRepository)
    {

    }

    public function getAllDivisions(): Collection
    {
        return $this->divisionRepository->getAll();
    }

    public function create(array $data): string
    {
        if (! Auth::user()->hasPermissionTo('create_division')) {
            return 'You do not have permission to create a division.';
        }

        $this->divisionRepository->create($data);

        return 'Division created successfully.';
    }

    public function update(int $id, array $data): string
    {
        if (! Auth::user()->hasPermissionTo('edit_division')) {
            return 'You do not have permission to edit a division.';
        }

        $division = $this->divisionRepository->getById($id);
        if (! $division) {
            return 'Division not found.';
        }

        $this->divisionRepository->update($id, $data);

        return 'Division updated successfully.';
    }

    public function delete(int $id): string
    {
        if (! Auth::user()->hasPermissionTo('delete_division')) {
            return 'You do not have permission to delete a division.';
        }

        $deleted = $this->divisionRepository->delete($id);
        if (! $deleted) {
            return 'Failed to delete division.';
        }

        return 'Division deleted successfully.';
    }

    public function getById(int $id): ?Division
    {
        return $this->divisionRepository->getById($id);
    }
}
