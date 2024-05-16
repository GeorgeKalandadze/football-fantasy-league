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

    public function store(PlayerRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $response = $this->playerService->create($validatedData);

        return response()->json(['message' => $response], 201);
    }

    public function show(Player $player): JsonResponse|Response
    {
        $player = $this->playerService->getById($player->id);
        if ($player) {
            return $this->ok(new PlayerResource($player));
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

        return response()->json(['message' => $response], 204);
    }
}
