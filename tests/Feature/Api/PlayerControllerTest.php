<?php

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PlayerControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_get_all_players()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->getJson('/api/players');
        $response->assertStatus(200);
    }

    public function test_can_create_player()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $team = Team::factory()->create();
        $playerData = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'age' => 25,
            'market_price' => 15,
            'country_id' => 1,
            'position_id' => 1,
            'team_id' => $team->id,
        ];

        $response = $this->postJson('/api/players', $playerData);
        $response->assertStatus(201);

    }

    public function test_can_get_player_by_id()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $player = Player::factory()->create();

        $response = $this->getJson("/api/players/{$player->id}");
        $response->assertStatus(200);

    }

    public function test_can_update_player()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $player = Player::factory()->create();
        $team = Team::factory()->create();
        $updatedData = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'age' => 25,
            'market_price' => 18,
            'country_id' => 1,
            'position_id' => 1,
            'team_id' => $team->id,
        ];

        $response = $this->putJson("/api/players/{$player->id}", $updatedData);
        $response->assertStatus(200);

    }

    public function test_can_delete_player()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $player = Player::factory()->create();
        $response = $this->deleteJson("/api/players/{$player->id}");
        $response->assertStatus(204);
    }
}
