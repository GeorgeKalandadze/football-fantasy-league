<?php

namespace App\Repositories;

use App\Models\Division;

class DivisionRepository implements Contracts\DivisionRepositoryContract
{
    public function getAll(): array
    {
        return Division::all()->toArray();
    }

    public function create(array $data): Division
    {
        return Division::create($data);
    }

    public function update(int $id, array $data): Division
    {
        $division = Division::findOrFail($id);
        $division->update($data);

        return $division;
    }

    public function delete(int $id): bool
    {
        return Division::destroy($id);
    }

    public function getById(int $id): ?Division
    {
        return Division::find($id);
    }
}
