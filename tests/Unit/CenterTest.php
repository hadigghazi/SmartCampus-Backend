<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Center;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;

class CenterTest extends TestCase
{
    public function testIndex()
    {
        $centers = Mockery::mock(Collection::class);
        $centers->shouldReceive('all')->andReturn(collect([]));

        $centerModel = Mockery::mock(Center::class);
        $centerModel->shouldReceive('all')->andReturn($centers);

        $response = $this->getJson('/api/centers');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testStore()
    {
        $requestData = [
            'name' => 'New Center',
            'vision' => 'Vision statement',
            'mission' => 'Mission statement',
            'overview' => 'Overview of the center',
        ];

        $center = Mockery::mock(Center::class);
        $center->shouldReceive('create')->with($requestData)->andReturn($center);

        $response = $this->postJson('/api/centers', $requestData);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testShow()
    {
        $center = Mockery::mock(Center::class);
        $center->shouldReceive('findOrFail')->with(1)->andReturn($center);

        $response = $this->getJson('/api/centers/4');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdate()
    {
        $requestData = [
            'name' => 'Updated Center',
            'vision' => 'Updated Vision',
            'mission' => 'Updated Mission',
            'overview' => 'Updated Overview',
        ];

        $center = Mockery::mock(Center::class);
        $center->shouldReceive('findOrFail')->with(1)->andReturn($center);
        $center->shouldReceive('update')->with($requestData)->andReturn(true);

        $response = $this->putJson('/api/centers/4', $requestData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDestroy()
    {
        $center = Mockery::mock(Center::class);
        $center->shouldReceive('findOrFail')->with(1)->andReturn($center);
        $center->shouldReceive('delete')->andReturn(true);

        $response = $this->deleteJson('/api/centers/4');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testRestore()
    {
        $center = Mockery::mock(Center::class);
        $center->shouldReceive('findOrFail')->with(1)->andReturn($center);
        $center->shouldReceive('restore')->andReturn(true);

        $response = $this->postJson('/api/centers/4/restore');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testForceDelete()
    {
        $center = Mockery::mock(Center::class);
        $center->shouldReceive('findOrFail')->with(1)->andReturn($center);
        $center->shouldReceive('forceDelete')->andReturn(true);

        $response = $this->deleteJson('/api/centers/4/force-delete');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
