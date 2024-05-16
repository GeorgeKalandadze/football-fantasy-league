<?php

namespace App\Http\Controllers;

use App\Http\Requests\DivisionRequest;
use App\Http\Resources\DivisionResource;
use App\Models\Division;
use App\Services\DivisionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DivisionController extends Controller
{
    public function __construct(private readonly DivisionService $divisionService)
    {

    }

    public function index(): Response
    {
        $divisions = $this->divisionService->getAllDivisions();

        return $this->ok(DivisionResource::collection($divisions));
    }

    public function store(DivisionRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $response = $this->divisionService->create($validatedData);

        return response()->json(['response' => $response], 201);
    }

    public function show(Division $division): JsonResponse|Response
    {
        $division = $this->divisionService->getById($division->id);
        if ($division) {
            return $this->ok(new DivisionResource($division));
        } else {
            return response()->json(['message' => 'Division not found'], 404);
        }
    }

    public function update(DivisionRequest $request, Division $division): JsonResponse
    {
        $validatedData = $request->validated();

        $response = $this->divisionService->update($division->id, $validatedData);

        return response()->json(['response' => $response], 200);
    }

    public function destroy(Division $division): JsonResponse
    {
        $response = $this->divisionService->delete($division->id);

        return response()->json(['response' => $response], 200);
    }
}
