<?php

namespace App\Http\Controllers;

use App\Exceptions\PlayerException;
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

    /**
     * @throws PlayerException
     */
    public function store(PlayerRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $this->playerService->create($validatedData);
        return response()->json(['message' => 'Player created successfully.'], 201);
    }

    /**
     * @throws PlayerException
     */
    public function show(Player $player): Response
    {
        $player = $this->playerService->getById($player->id);
        return $this->ok(new PlayerResource($player));
    }

    /**
     * @throws PlayerException
     */
    public function update(PlayerRequest $request, Player $player): JsonResponse
    {
        $validatedData = $request->validated();
        $this->playerService->update($player->id, $validatedData);
        return response()->json(['message' => 'Player updated successfully.'], 200);
    }

    /**
     * @throws PlayerException
     */
    public function destroy(Player $player): JsonResponse
    {
        $this->playerService->delete($player->id);
        return response()->json(['message' => 'Player deleted successfully.'], 204);
    }
}
