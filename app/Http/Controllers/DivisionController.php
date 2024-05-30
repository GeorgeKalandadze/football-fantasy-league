<?php

namespace App\Http\Controllers;

use App\Http\Requests\DivisionRequest;
use App\Http\Resources\DivisionResource;
use App\Models\Division;
use App\Services\DivisionService;
use Exception;
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

        try {
            $this->divisionService->create($validatedData);

            return response()->json(['message' => 'Division created successfully.'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function show(Division $division): JsonResponse|Response
    {
        try {
            $division = $this->divisionService->getById($division->id);

            return $this->ok(new DivisionResource($division));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function update(DivisionRequest $request, Division $division): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $this->divisionService->update($division->id, $validatedData);

            return response()->json(['message' => 'Division updated successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function destroy(Division $division): JsonResponse
    {
        try {
            $this->divisionService->delete($division->id);

            return response()->json(['message' => 'Division deleted successfully.'], 204);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
