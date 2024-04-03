<?php
namespace App\Repositories;

use App\Models\Player;
use App\Repositories\Contracts\PlayerRepositoryContract;

class PlayerRepository implements PlayerRepositoryContract
{
    public function getAll(): array
    {
        return Player::all()->toArray();
    }

    public function create(array $data): Player
    {
        return Player::create($data);
    }

    public function update(int $id, array $data): Player
    {
        $player = Player::findOrFail($id);
        $player->update($data);
        return $player;
    }

    public function delete(int $id): bool
    {
        return Player::destroy($id);
    }

    public function getById(int $id): ?Player
    {
        return Player::find($id);
    }
}
