<?php

namespace App\Http\Controllers;

use App\Http\Requests\FantasyTeamRequest;
use App\Http\Resources\FantasyTeamResource;
use App\Services\FantasyTeamService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FantasyTeamController extends Controller
{
    public function __construct(private readonly FantasyTeamService $fantasyTeamService)
    {
    }

    public function index(): Response
    {
        $fantasyTeams = $this->fantasyTeamService->getAllFantasyTeams();

        return $this->ok(FantasyTeamResource::collection($fantasyTeams));
    }

    public function show(int $id): JsonResponse|Response
    {
        try {
            $fantasyTeam = $this->fantasyTeamService->getFantasyTeamById($id);
            if (! $fantasyTeam) {
                return response()->json(['message' => 'Fantasy team not found.'], 404);
            }

            return $this->ok(new FantasyTeamResource($fantasyTeam));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function store(FantasyTeamRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $fantasyTeam = $this->fantasyTeamService->createFantasyTeam($data);

            return response()->json(['message' => 'Fantasy team created successfully.', 'fantasy_team' => new FantasyTeamResource($fantasyTeam)], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function update(FantasyTeamRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $fantasyTeam = $this->fantasyTeamService->updateFantasyTeam($id, $data);

            return response()->json(['message' => 'Fantasy team updated successfully.', 'fantasy_team' => new FantasyTeamResource($fantasyTeam)], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->fantasyTeamService->deleteFantasyTeam($id);

            return response()->json(['message' => 'Fantasy team deleted successfully.'], 204);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
