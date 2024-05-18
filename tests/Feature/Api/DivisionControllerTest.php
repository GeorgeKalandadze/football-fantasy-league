<?php

namespace Tests\Feature;

use App\Models\Division;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DivisionControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_get_all_divisions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->getJson('/api/divisions');
        $response->assertStatus(200);

    }

    public function test_can_create_division()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('create_division');
        Sanctum::actingAs($user);

        $divisionData = [
            'name' => 'Test Division',
        ];

        $response = $this->postJson('/api/divisions', $divisionData);
        $response->assertStatus(201);
    }

    public function test_can_get_division_by_id()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $division = Division::factory()->create();

        $response = $this->getJson("/api/divisions/{$division->id}");
        $response->assertStatus(200);

    }

    public function test_can_update_division()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('edit_division');
        Sanctum::actingAs($user);

        $division = Division::factory()->create();
        $updatedData = [
            'name' => 'Updated Division Name',
        ];

        $response = $this->putJson("/api/divisions/{$division->id}", $updatedData);
        $response->assertStatus(200);
    }

    public function test_can_delete_division()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('delete_division');
        Sanctum::actingAs($user);

        $division = Division::factory()->create();
        $response = $this->deleteJson("/api/divisions/{$division->id}");
        $response->assertStatus(204);
    }
}
