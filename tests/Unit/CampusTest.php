<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Campus;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CampusTest extends TestCase
{
    public function testIndex()
    {
        $campuses = Mockery::mock(Collection::class);
        $campuses->shouldReceive('get')->andReturn(collect([]));

        $campusModel = Mockery::mock(Campus::class);
        $campusModel->shouldReceive('get')->andReturn($campuses);

        $response = $this->getJson('/api/campuses');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testStore()
    {
        $requestData = [
            'name' => 'New Campus',
            'location' => 'Location',
            'description' => 'Campus description',
        ];

        $campus = Mockery::mock(Campus::class);
        $campus->shouldReceive('create')->with($requestData)->andReturn($campus);

        $response = $this->postJson('/api/campuses', $requestData);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testShow()
    {
        $campus = Mockery::mock(Campus::class);
        $campus->shouldReceive('findOrFail')->with(1)->andReturn($campus);

        $response = $this->getJson('/api/campuses/11');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdate()
    {
        $requestData = [
            'name' => 'Updated Campus',
            'location' => 'Updated Location',
            'description' => 'Updated description',
        ];

        $campus = Mockery::mock(Campus::class);
        $campus->shouldReceive('findOrFail')->with(1)->andReturn($campus);
        $campus->shouldReceive('update')->with($requestData)->andReturn(true);

        $response = $this->putJson('/api/campuses/11', $requestData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDestroy()
    {
        $campus = Mockery::mock(Campus::class);
        $campus->shouldReceive('findOrFail')->with(1)->andReturn($campus);
        $campus->shouldReceive('delete')->andReturn(true);

        $response = $this->deleteJson('/api/campuses/11');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testRestore()
    {
        $campus = Mockery::mock(Campus::class);
        $campus->shouldReceive('findOrFail')->with(1)->andReturn($campus);
        $campus->shouldReceive('restore')->andReturn(true);

        $response = $this->postJson('/api/campuses/11/restore');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testForceDelete()
    {
        $campus = Mockery::mock(Campus::class);
        $campus->shouldReceive('findOrFail')->with(1)->andReturn($campus);
        $campus->shouldReceive('forceDelete')->andReturn(true);

        $response = $this->deleteJson('/api/campuses/11/force-delete');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
