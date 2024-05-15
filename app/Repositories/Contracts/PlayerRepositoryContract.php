<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface PlayerRepositoryContract
{
    public function getAll(): Collection;

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getById(int $id);
}
