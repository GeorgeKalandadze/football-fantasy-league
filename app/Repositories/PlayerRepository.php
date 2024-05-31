<?php

namespace App\Repositories;

use App\Models\Player;
use App\Repositories\Contracts\PlayerRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class PlayerRepository implements PlayerRepositoryContract
{
    public function getAll(): Collection
    {
        return Player::with('country', 'position')->get();
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

    public function getById(int $id)
    {
        return Player::with('country', 'position')->findOrFail($id);
    }
}
