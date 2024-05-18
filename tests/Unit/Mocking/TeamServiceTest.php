<?php

namespace Mocking;

use App\Models\Team;
use App\Repositories\Contracts\DivisionRepositoryContract;
use App\Repositories\Contracts\TeamRepositoryContract;
use App\Services\TeamService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TeamServiceTest extends TestCase
{
    protected $teamRepository;

    protected $divisionRepository;

    protected $teamService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teamRepository = $this->createMock(TeamRepositoryContract::class);
        $this->divisionRepository = $this->createMock(DivisionRepositoryContract::class);
        $this->teamService = new TeamService($this->teamRepository, $this->divisionRepository);
    }

    public function testGetAllTeams()
    {
        $teams = new collection([
            new Team(['name' => 'Team 1']),
            new Team(['name' => 'Team 2']),
            new Team(['name' => 'Team 3']),
        ]);
        $this->teamRepository->expects($this->once())
            ->method('getAll')
            ->willReturn($teams);

        $result = $this->teamService->getAllTeams();

        $this->assertCount(3, $result);
        foreach ($result as $team) {
            $this->assertInstanceOf(Team::class, $team);
        }
    }

    public function testCreateTeam()
    {
        Auth::shouldReceive('user->hasPermissionTo')
            ->with('create_team')
            ->andReturn(true);

        $teamData = ['name' => 'New Team'];
        $this->teamRepository->expects($this->once())
            ->method('create')
            ->with($teamData);

        $this->teamService->create($teamData);

    }

    public function testUpdateTeam()
    {
        Auth::shouldReceive('user->hasPermissionTo')
            ->with('edit_team')
            ->andReturn(true);

        $teamId = 1;
        $teamData = ['name' => 'Updated Team'];
        $this->teamRepository->expects($this->once())
            ->method('getById')
            ->with($teamId)
            ->willReturn(new Team());

        $this->teamRepository->expects($this->once())
            ->method('update')
            ->with($teamId, $teamData);

        $this->teamService->update($teamId, $teamData);

    }

    public function testDeleteTeam()
    {
        Auth::shouldReceive('user->hasPermissionTo')
            ->with('delete_team')
            ->andReturn(true);

        $teamId = 1;
        $this->teamRepository->expects($this->once())
            ->method('delete')
            ->with($teamId)
            ->willReturn(true);

        $this->teamService->delete($teamId);

    }

    public function testGetTeamById()
    {
        $teamId = 1;
        $team = new Team();
        $this->teamRepository->expects($this->once())
            ->method('getById')
            ->with($teamId)
            ->willReturn($team);

        $result = $this->teamService->getById($teamId);

        $this->assertEquals($team, $result);
    }
}
