<?php
namespace App\Services;

use App\Models\Player;
use \App\Repositories\Contracts\PlayerRepositoryContract;

class PlayerService
{

    public function __construct(protected PlayerRepositoryContract $playerRepository)
    {

    }

    public function getAllPlayers(): array
    {
        return $this->playerRepository->getAll();
    }

    public function create(array $data): Player
    {
        return $this->playerRepository->create($data);
    }

    public function update(int $id, array $data): Player
    {
        return $this->playerRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->playerRepository->delete($id);
    }

    public function getById(int $id): ?Player
    {
        return $this->playerRepository->getById($id);
    }

}
