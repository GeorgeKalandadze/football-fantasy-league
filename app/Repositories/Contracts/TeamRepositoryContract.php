<?php

namespace App\Repositories\Contracts;

interface TeamRepositoryContract
{
    public function getAll(): array;

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getById(int $id);
}
