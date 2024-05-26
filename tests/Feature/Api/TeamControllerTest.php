<?php

namespace Tests\Feature;

use App\Models\Division;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TeamControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_get_all_teams()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->getJson('/api/teams');
        $response->assertStatus(200);
    }

    public function test_can_create_team()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('create_team');
        Sanctum::actingAs($user);

        $division = Division::factory()->create();
        $teamData = [
            'name' => 'Test Team',
            'country_id' => 1,
            'division_id' => $division->id,
        ];

        $response = $this->postJson('/api/teams', $teamData);
        $response->assertStatus(201);
    }

    public function test_can_get_team_by_id()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $team = Team::factory()->create();

        $response = $this->getJson("/api/teams/{$team->id}");
        $response->assertStatus(200);

    }

    public function test_can_update_team()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('edit_team');
        Sanctum::actingAs($user);
        $division = Division::factory()->create();
        $team = Team::factory()->create();
        $updatedData = [
            'name' => 'Updated Team Name',
            'country_id' => 1,
            'division_id' => $division->id,
        ];

        $response = $this->putJson("/api/teams/{$team->id}", $updatedData);
        $response->assertStatus(200);
    }

    public function test_can_delete_team()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('delete_team');
        Sanctum::actingAs($user);

        $team = Team::factory()->create();
        $response = $this->deleteJson("/api/teams/{$team->id}");
        $response->assertStatus(200);

    }
}
