<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Services\TeamService;
use Exception;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    protected TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function index(): JsonResponse
    {
        $teams = $this->teamService->getAllTeams();

        return response()->json(TeamResource::collection($teams));
    }

    public function store(TeamRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $this->teamService->create($validatedData);

            return response()->json(['message' => 'Team created successfully'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function show(Team $team): JsonResponse
    {
        try {
            $team = $this->teamService->getById($team->id);

            return response()->json(new TeamResource($team));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function update(TeamRequest $request, Team $team): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $this->teamService->update($team->id, $validatedData);

            return response()->json(['message' => 'Team updated successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function destroy(Team $team): JsonResponse
    {
        try {
            $this->teamService->delete($team->id);

            return response()->json(['message' => 'Team deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
