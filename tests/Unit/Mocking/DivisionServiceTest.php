<?php

namespace Mocking;

use App\Models\Division;
use App\Repositories\Contracts\DivisionRepositoryContract;
use App\Services\DivisionService;
use Illuminate\Database\Eloquent\Collection;
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
        $divisions = new Collection([new Division(), new Division()]);

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

        $this->divisionService->create($divisionData, Auth::user());

        $this->assertTrue(true);
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

        $this->divisionService->update($divisionId, $divisionData, Auth::user());

        $this->assertTrue(true);
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
            ->willThrowException(new \Exception('Failed to delete division.', 400));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to delete division.');
        $this->expectExceptionCode(400);

        $this->divisionService->delete($divisionId, Auth::user());
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
