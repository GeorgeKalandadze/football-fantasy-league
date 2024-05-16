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

    public function store(DivisionRequest $request): Response
    {
        $validatedData = $request->validated();

        $response = $this->divisionService->create($validatedData);

        return $this->created($response);
    }

    public function show(Division $division): Response
    {
        $division = $this->divisionService->getById($division->id);
        if ($division) {
            return $this->ok(new DivisionResource($division));
        } else {
            return $this->notFound('Division not found');
        }
    }

    public function update(DivisionRequest $request, Division $division): Response
    {
        $validatedData = $request->validated();

        $response = $this->divisionService->update($division->id, $validatedData);

        return $this->ok($response);
    }

    public function destroy(Division $division): Response
    {
        $this->divisionService->delete($division->id);
        return $this->noContent();
    }
}
