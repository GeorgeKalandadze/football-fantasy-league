<?php

namespace App\Http\Controllers;

use App\Http\Requests\DivisionRequest;
use App\Models\Division;
use App\Services\DivisionService;
use Illuminate\Http\JsonResponse;

class DivisionController extends Controller
{
    public function __construct(protected DivisionService $divisionService)
    {

    }

    public function index(): JsonResponse
    {
        $divisions = $this->divisionService->getAllDivisions();

        return response()->json(['divisions' => $divisions], 200);
    }

    public function store(DivisionRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $response= $this->divisionService->create($validatedData);

        return response()->json(['response' => $response], 201);
    }

    public function show(Division $division): JsonResponse
    {
        $division = $this->divisionService->getById($division->id);
        if ($division) {
            return response()->json(['division' => $division], 200);
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
