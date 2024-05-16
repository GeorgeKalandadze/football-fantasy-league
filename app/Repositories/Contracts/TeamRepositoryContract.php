<?php

namespace App\Repositories\Contracts;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

interface TeamRepositoryContract
{
    public function getAll(): Collection;

    public function create(array $data): Team;

    public function update(int $id, array $data): Team;

    public function delete(int $id): bool;

    public function getById(int $id);
}
