<?php

namespace App\Http\Controllers;

use App\Http\Requests\FantasyTeamRequest;
use App\Http\Resources\FantasyTeamResource;
use App\Services\FantasyTeamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FantasyTeamController extends Controller
{
    public function __construct(protected FantasyTeamService $fantasyTeamService)
    {

    }

    public function index(): Response
    {
        $fantasyTeams = $this->fantasyTeamService->getAllFantasyTeams();

        return $this->ok(FantasyTeamResource::collection($fantasyTeams));
    }

    public function show(int $id): JsonResponse|Response
    {
        $fantasyTeam = $this->fantasyTeamService->getFantasyTeamById($id);
        if (! $fantasyTeam) {
            return response()->json(['message' => 'Fantasy team not found.'], 404);
        }

        return $this->ok(new FantasyTeamResource($fantasyTeam));
    }

    public function store(FantasyTeamRequest $request): JsonResponse
    {
        $data = $request->validated();
        $response = $this->fantasyTeamService->createFantasyTeam($data);

        return response()->json(['message' => $response->original['message']], 201);
    }

    public function update(FantasyTeamRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $response = $this->fantasyTeamService->updateFantasyTeam($id, $data);

        return response()->json(['message' => $response->original['message']], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $response = $this->fantasyTeamService->deleteFantasyTeam($id);

        return response()->json(['response' => $response], 204);
    }
}
