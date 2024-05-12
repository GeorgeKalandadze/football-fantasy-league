<?php

namespace Mocking;

use App\Models\Division;
use App\Repositories\Contracts\DivisionRepositoryContract;
use App\Services\DivisionService;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\TestCase;

class DivisionServiceTest extends TestCase
{
    protected $divisionRepository;
    protected $divisionService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->divisionRepository = $this->createMock(DivisionRepositoryContract::class);

        $this->divisionService = new DivisionService($this->divisionRepository);
    }

    public function testGetAllDivisions()
    {
        $divisions = [new Division(), new Division()];
        $this->divisionRepository->expects($this->once())
            ->method('getAll')
            ->willReturn($divisions);

        $result = $this->divisionService->getAllDivisions();

        $this->assertEquals($divisions, $result);
    }

    public function testCreateDivision()
    {
        Auth::shouldReceive('user->hasPermissionTo')
            ->with('create_division')
            ->andReturn(true);

        $divisionData = ['name' => 'New Division'];
        $this->divisionRepository->expects($this->once())
            ->method('create')
            ->with($divisionData);

        $result = $this->divisionService->create($divisionData);

        $this->assertEquals('Division created successfully.', $result);
    }

    public function testUpdateDivision()
    {
        Auth::shouldReceive('user->hasPermissionTo')
            ->with('edit_division')
            ->andReturn(true);

        $divisionId = 1;
        $divisionData = ['name' => 'Updated Division'];
        $this->divisionRepository->expects($this->once())
            ->method('getById')
            ->with($divisionId)
            ->willReturn(new Division());

        $this->divisionRepository->expects($this->once())
            ->method('update')
            ->with($divisionId, $divisionData);

        $result = $this->divisionService->update($divisionId, $divisionData);

        $this->assertEquals('Division updated successfully.', $result);
    }

    public function testDeleteDivision()
    {
        Auth::shouldReceive('user->hasPermissionTo')
            ->with('delete_division')
            ->andReturn(true);

        $divisionId = 1;
        $this->divisionRepository->expects($this->once())
            ->method('delete')
            ->with($divisionId)
            ->willReturn(true);

        $result = $this->divisionService->delete($divisionId);

        $this->assertEquals('Division deleted successfully.', $result);
    }

    public function testGetDivisionById()
    {
        $divisionId = 1;
        $division = new Division();
        $this->divisionRepository->expects($this->once())
            ->method('getById')
            ->with($divisionId)
            ->willReturn($division);

        $result = $this->divisionService->getById($divisionId);

        $this->assertEquals($division, $result);
    }
}
