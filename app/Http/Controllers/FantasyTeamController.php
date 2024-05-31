<?php

namespace App\Http\Controllers;

use App\Exceptions\FantasyTeamException;
use App\Http\Requests\FantasyTeamRequest;
use App\Http\Resources\FantasyTeamResource;
use App\Models\FantasyTeam;
use App\Services\FantasyTeamService;
use Illuminate\Http\JsonResponse;

class FantasyTeamController extends Controller
{
    protected FantasyTeamService $fantasyTeamService;

    public function __construct(FantasyTeamService $fantasyTeamService)
    {
        $this->fantasyTeamService = $fantasyTeamService;
    }

    public function index(): JsonResponse
    {
        $fantasyTeams = $this->fantasyTeamService->getAllFantasyTeams();
        return response()->json(FantasyTeamResource::collection($fantasyTeams));
    }

    /**
     * @throws FantasyTeamException
     */
    public function store(FantasyTeamRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $user = auth()->user();
        $fantasyTeam = $this->fantasyTeamService->createFantasyTeam($validatedData, $user);
        return response()->json(new FantasyTeamResource($fantasyTeam), 201);
    }

    public function show(FantasyTeam $fantasyTeam): JsonResponse
    {
        $fantasyTeam = $this->fantasyTeamService->getFantasyTeamById($fantasyTeam->id);
        return response()->json(new FantasyTeamResource($fantasyTeam));
    }

    /**
     * @throws FantasyTeamException
     */
    public function update(FantasyTeamRequest $request, FantasyTeam $fantasyTeam): JsonResponse
    {
        $validatedData = $request->validated();
        $user = auth()->user();
        $updatedFantasyTeam = $this->fantasyTeamService->updateFantasyTeam($fantasyTeam->id, $validatedData, $user);
        return response()->json(new FantasyTeamResource($updatedFantasyTeam), 200);
    }

    /**
     * @throws FantasyTeamException
     */
    public function destroy(FantasyTeam $fantasyTeam): JsonResponse
    {
        $this->fantasyTeamService->deleteFantasyTeam($fantasyTeam->id);
        return response()->json(['message' => 'Fantasy team deleted successfully'], 204);
    }
}
