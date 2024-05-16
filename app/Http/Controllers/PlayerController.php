<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerRequest;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Services\PlayerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PlayerController extends Controller
{
    public function __construct(private readonly PlayerService $playerService)
    {

    }

    public function index(): Response
    {
        $players = $this->playerService->getAllPlayers();

        return $this->ok(PlayerResource::collection($players));
    }

    public function store(PlayerRequest $request): Response
    {
        $validatedData = $request->validated();

        $response = $this->playerService->create($validatedData);

        return $this->created($response);
    }

    public function show(Player $player): Response
    {
        $player = $this->playerService->getById($player->id);
        if ($player) {
            return $this->ok(new PlayerResource($player));
        } else {
            return $this->notFound('Division not found');
        }
    }

    public function update(PlayerRequest $request, Player $player): Response
    {
        $validatedData = $request->validated();

        $response = $this->playerService->update($player->id, $validatedData);

        return $this->ok($response);
    }

    public function destroy(Player $player): Response
    {
        $this->playerService->delete($player->id);
        return $this->noContent();
    }
}
