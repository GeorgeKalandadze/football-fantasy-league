<?php

namespace Mocking;

use App\Models\Player;
use App\Repositories\Contracts\PlayerRepositoryContract;
use App\Repositories\Contracts\TeamRepositoryContract;
use App\Services\PlayerService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\TestCase;

class PlayerServiceTest extends TestCase
{
    protected $playerRepository;

    protected $teamRepository;

    protected $playerService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->playerRepository = $this->createMock(PlayerRepositoryContract::class);
        $this->teamRepository = $this->createMock(TeamRepositoryContract::class);
        $this->playerService = new PlayerService($this->playerRepository, $this->teamRepository);
    }

    public function testGetAllPlayers()
    {
        $players = new Collection([
            new Player(['name' => 'Player 1']),
            new Player(['name' => 'Player 2']),
            new Player(['name' => 'Player 3']),
        ]);
        $this->playerRepository->expects($this->once())
            ->method('getAll')
            ->willReturn($players);

        $result = $this->playerService->getAllPlayers();

        $this->assertCount(3, $result);
        foreach ($result as $player) {
            $this->assertInstanceOf(Player::class, $player);
        }
    }

    public function testCreatePlayer()
    {
        Auth::shouldReceive('user->hasPermissionTo')
            ->with('create_player')
            ->andReturn(true);

        $playerData = ['name' => 'New Player', 'team_id' => 1];
        $this->playerRepository->expects($this->once())
            ->method('create')
            ->with($playerData);

        $this->playerService->create($playerData);

    }

    public function testUpdatePlayer()
    {
        Auth::shouldReceive('user->hasPermissionTo')
            ->with('edit_player')
            ->andReturn(true);

        $playerId = 1;
        $playerData = ['name' => 'Updated Player', 'team_id' => 1];
        $this->playerRepository->expects($this->once())
            ->method('getById')
            ->with($playerId)
            ->willReturn(new Player());

        $this->playerRepository->expects($this->once())
            ->method('update')
            ->with($playerId, $playerData);

        $this->playerService->update($playerId, $playerData);

    }

    public function testDeletePlayer()
    {
        Auth::shouldReceive('user->hasPermissionTo')
            ->with('delete_player')
            ->andReturn(true);

        $playerId = 1;
        $this->playerRepository->expects($this->once())
            ->method('delete')
            ->with($playerId)
            ->willReturn(true);

       $this->playerService->delete($playerId);


    }

    public function testGetPlayerById()
    {
        $playerId = 1;
        $player = new Player();
        $this->playerRepository->expects($this->once())
            ->method('getById')
            ->with($playerId)
            ->willReturn($player);

        $result = $this->playerService->getById($playerId);

        $this->assertEquals($player, $result);
    }
}
