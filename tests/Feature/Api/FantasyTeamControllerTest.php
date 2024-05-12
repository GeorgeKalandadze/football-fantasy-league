<?php

namespace Tests\Feature;

use App\Models\FantasyTeam;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FantasyTeamControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_get_all_fantasy_teams()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->getJson('/api/fantasy-teams');
        $response->assertStatus(200)
            ->assertJsonStructure(['fantasy_teams']);
    }

    public function test_can_create_fantasy_team()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $players = Player::factory()->count(8)->create();
        $playerIds = $players->map->id->toArray();

        $teamData = [
            'name' => 'Test Team',
            'players' => $playerIds,
        ];

        $response = $this->postJson('/api/fantasy-teams', $teamData);
        $response->assertStatus(201);

    }

    public function test_can_get_fantasy_team_by_id()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $team = FantasyTeam::factory()->create();

        $response = $this->getJson("/api/fantasy-teams/{$team->id}");
        $response->assertStatus(200);

    }

    public function test_can_update_fantasy_team()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $players = Player::factory()->count(8)->create();

        $playerIds = $players->map->id->toArray();

        $team = FantasyTeam::factory()->create([
            'user_id' => $user->id,
        ]);

        $teamData = [
            'name' => 'Updated Team Name',
            'players' => $playerIds,
        ];

        $response = $this->putJson("/api/fantasy-teams/{$team->id}", $teamData);
        $response->assertStatus(200);
    }

    public function test_can_delete_fantasy_team()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $team = FantasyTeam::factory()->create();
        $response = $this->deleteJson("/api/fantasy-teams/{$team->id}");
        $response->assertStatus(204);

    }
}
