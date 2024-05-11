<?php

namespace App\Http\Controllers;

use App\Http\Requests\FantasyTeamRequest;
use App\Services\FantasyTeamService;
use Illuminate\Http\JsonResponse;

class FantasyTeamController extends Controller
{
    public function __construct(protected FantasyTeamService $fantasyTeamService)
    {

    }

    public function index(): JsonResponse
    {
        $fantasyTeams = $this->fantasyTeamService->getAllFantasyTeams();

        return response()->json(['fantasy_teams' => $fantasyTeams], 200);
    }

    public function show(int $id): JsonResponse
    {
        $fantasyTeam = $this->fantasyTeamService->getFantasyTeamById($id);
        if (! $fantasyTeam) {
            return response()->json(['message' => 'Fantasy team not found.'], 404);
        }

        return response()->json(['fantasy_team' => $fantasyTeam], 200);
    }

    public function store(FantasyTeamRequest $request): JsonResponse
    {
        $data = $request->validated();
        $response = $this->fantasyTeamService->createFantasyTeam($data);

        return response()->json(['message' => $response->original['message']], $response->getStatusCode());
    }

    public function update(FantasyTeamRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $response = $this->fantasyTeamService->updateFantasyTeam($id, $data);

        return response()->json(['message' => $response->original['message']]);
    }

    public function destroy(int $id): JsonResponse
    {
        $response = $this->fantasyTeamService->deleteFantasyTeam($id);

        return response()->json(['response' => $response], 201);
    }
}
