<?php

namespace Tests\Feature;

use App\Models\FantasyTeam;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
        $response->assertStatus(200);
    }

    public function test_can_create_fantasy_team()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $goalkeepers = Player::factory()->count(1)->create(['position_id' => 1, 'market_price' => 6]);
        $defenders = Player::factory()->count(2)->create(['position_id' => 2, 'market_price' => 6]);
        $midfielders = Player::factory()->count(3)->create(['position_id' => 3, 'market_price' => 6]);
        $forwards = Player::factory()->count(2)->create(['position_id' => 4, 'market_price' => 6]);

        $players = $goalkeepers->merge($defenders)->merge($midfielders)->merge($forwards);
        $playerIds = $players->pluck('id')->toArray();

        $teamData = [
            'name' => 'Test Team',
            'players' => $playerIds,
        ];

        $response = $this->postJson('/api/fantasy-teams', $teamData);
        $response->assertStatus(201);
    }

    public function test_can_update_fantasy_team()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $goalkeepers = Player::factory()->count(1)->create(['position_id' => 1, 'market_price' => 6]);
        $defenders = Player::factory()->count(2)->create(['position_id' => 2, 'market_price' => 6]);
        $midfielders = Player::factory()->count(3)->create(['position_id' => 3, 'market_price' => 6]);
        $forwards = Player::factory()->count(2)->create(['position_id' => 4, 'market_price' => 6]);

        $players = $goalkeepers->merge($defenders)->merge($midfielders)->merge($forwards);
        $playerIds = $players->pluck('id')->toArray();

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
        $user->givePermissionTo('delete_fantasy_team');
        Sanctum::actingAs($user);

        $team = FantasyTeam::factory()->create();
        $response = $this->deleteJson("/api/fantasy-teams/{$team->id}");
        $response->assertStatus(204);

    }
}
