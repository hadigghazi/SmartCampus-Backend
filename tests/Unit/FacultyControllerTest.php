<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class FacultyControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anyone_can_access_index_and_show_routes()
    {
        $faculties = Faculty::factory()->count(3)->create();

        $response = $this->getJson('/api/faculties');
        $response->assertStatus(200)
                 ->assertJsonCount(3);

        $response = $this->getJson('/api/faculties/' . $faculties[0]->id);
        $response->assertStatus(200)
                 ->assertJsonStructure(['id', 'name', 'description']);
    }

    /** @test */
    public function only_admin_can_create_a_faculty()
    {
        $response = $this->postJson('/api/faculties', [
            'name' => 'New Faculty',
            'description' => 'Faculty description',
        ]);
        $response->assertStatus(401); 

        $admin = User::factory()->create(['role' => 'Admin']);
        Sanctum::actingAs($admin);

        $response = $this->postJson('/api/faculties', [
            'name' => 'New Faculty',
            'description' => 'Faculty description',
        ]);
        $response->assertStatus(201) 
                 ->assertJson(['name' => 'New Faculty']);
    }

    /** @test */
    public function only_admin_can_update_a_faculty()
    {
        $faculty = Faculty::factory()->create();

        $response = $this->putJson("/api/faculties/{$faculty->id}", [
            'name' => 'Updated Faculty',
        ]);
        $response->assertStatus(401); 

        $admin = User::factory()->create(['role' => 'Admin']);
        Sanctum::actingAs($admin);

        $response = $this->putJson("/api/faculties/{$faculty->id}", [
            'name' => 'Updated Faculty',
        ]);
        $response->assertStatus(200) 
                 ->assertJson(['name' => 'Updated Faculty']);
    }

    /** @test */
    public function only_admin_can_delete_a_faculty()
    {
        $faculty = Faculty::factory()->create();

        $response = $this->deleteJson("/api/faculties/{$faculty->id}");
        $response->assertStatus(401); 

        $admin = User::factory()->create(['role' => 'Admin']);
        Sanctum::actingAs($admin);

        $response = $this->deleteJson("/api/faculties/{$faculty->id}");
        $response->assertStatus(204);
    }

    /** @test */
    public function only_admin_can_restore_a_deleted_faculty()
    {
        $faculty = Faculty::factory()->create();
        $faculty->delete();

        $response = $this->postJson("/api/faculties/{$faculty->id}/restore");
        $response->assertStatus(401); 

        $admin = User::factory()->create(['role' => 'Admin']);
        Sanctum::actingAs($admin);

        $response = $this->postJson("/api/faculties/{$faculty->id}/restore");
        $response->assertStatus(200);
    }

    /** @test */
    public function only_admin_can_force_delete_a_faculty()
    {
        $faculty = Faculty::factory()->create();
        $faculty->delete();

        $response = $this->deleteJson("/api/faculties/{$faculty->id}/force-delete");
        $response->assertStatus(401); 

        $admin = User::factory()->create(['role' => 'Admin']);
        Sanctum::actingAs($admin);

        $response = $this->deleteJson("/api/faculties/{$faculty->id}/force-delete");
        $response->assertStatus(204);
    }
}
