<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerRequest;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Services\PlayerService;
use Exception;
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
        try {
            $this->playerService->create($validatedData);

            return response()->json(['message' => 'Player created successfully.'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function show(Player $player): JsonResponse|Response
    {
        try {
            $player = $this->playerService->getById($player->id);

            return $this->ok(new PlayerResource($player));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function update(PlayerRequest $request, Player $player): JsonResponse
    {
        $validatedData = $request->validated();
        try {
            $this->playerService->update($player->id, $validatedData);

            return response()->json(['message' => 'Player updated successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function destroy(Player $player): JsonResponse
    {
        try {
            $this->playerService->delete($player->id);

            return response()->json(['message' => 'Player deleted successfully.'], 204);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
