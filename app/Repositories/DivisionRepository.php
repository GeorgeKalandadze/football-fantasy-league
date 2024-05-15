<?php

namespace App\Repositories;

use App\Models\Division;
use Illuminate\Database\Eloquent\Collection;

class DivisionRepository implements Contracts\DivisionRepositoryContract
{
    public function getAll(): Collection
    {
        return Division::with('teams')->get();
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
