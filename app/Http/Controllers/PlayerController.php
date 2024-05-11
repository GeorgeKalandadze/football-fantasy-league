<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerRequest;
use App\Models\Player;
use App\Services\PlayerService;
use Illuminate\Http\JsonResponse;

class PlayerController extends Controller
{
    public function __construct(protected PlayerService $playerService)
    {

    }

    public function index(): JsonResponse
    {
        $players = $this->playerService->getAllPlayers();

        return response()->json(['players' => $players], 200);
    }

    public function store(PlayerRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $response = $this->playerService->create($validatedData);

        return response()->json(['message' => $response]);
    }

    public function show(Player $player): JsonResponse
    {
        $player = $this->playerService->getById($player->id);
        if ($player) {
            return response()->json(['player' => $player], 200);
        } else {
            return response()->json(['message' => 'Player not found'], 404);
        }
    }

    public function update(PlayerRequest $request, Player $player): JsonResponse
    {
        $validatedData = $request->validated();

        $response = $this->playerService->update($player->id, $validatedData);

        return response()->json(['response' => $response], 200);
    }

    public function destroy(Player $player): JsonResponse
    {
        $response = $this->playerService->delete($player->id);

        return response()->json(['message' => $response], 200);
    }
}
