<?php

namespace App\Repositories\Contracts;

use App\Models\Player;
use Illuminate\Database\Eloquent\Collection;

interface PlayerRepositoryContract
{
    public function getAll(): Collection;

    public function create(array $data): Player;

    public function update(int $id, array $data): Player;

    public function delete(int $id): bool;

    public function getById(int $id);
}
