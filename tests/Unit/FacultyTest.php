<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Faculty;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FacultyTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testIndex()
    {
        $faculties = Mockery::mock(Collection::class);
        $faculties->shouldReceive('get')->andReturn(collect([]));
        
        $facultyModel = Mockery::mock(Faculty::class);
        $facultyModel->shouldReceive('get')->andReturn($faculties);
        
        $response = $this->getJson('/api/faculties');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testStore()
    {
        $requestData = [
            'name' => 'New Faculty',
            'description' => 'Faculty Description',
            'credit_price_usd' => 150.0
        ];

        $faculty = Mockery::mock(Faculty::class);
        $faculty->shouldReceive('create')->with($requestData)->andReturn($faculty);
        
        $response = $this->postJson('/api/faculties', $requestData);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testShow()
    {
        $faculty = Mockery::mock(Faculty::class);
        $faculty->shouldReceive('findOrFail')->andReturn($faculty);
        
        $response = $this->getJson('/api/faculties/10');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdate()
    {
        $requestData = [
            'name' => 'Updated Faculty',
            'description' => 'Updated Description',
            'credit_price_usd' => 150.0
        ];

        $faculty = Mockery::mock(Faculty::class);
        $faculty->shouldReceive('update')->with($requestData)->andReturn(true);
        
        $response = $this->putJson('/api/faculties/10', $requestData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDestroy()
    {
        $faculty = Mockery::mock(Faculty::class);
        $faculty->shouldReceive('delete')->andReturn(true);
        
        $response = $this->deleteJson('/api/faculties/10');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testRestore()
    {
        $faculty = Mockery::mock(Faculty::class);
        $faculty->shouldReceive('findOrFail')->with(1)->andReturn($faculty);
        $faculty->shouldReceive('restore')->andReturn(true);

        $response = $this->postJson('/api/faculties/10/restore');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testForceDelete()
    {
        $faculty = Mockery::mock(Faculty::class);
        $faculty->shouldReceive('findOrFail')->with(1)->andReturn($faculty);
        $faculty->shouldReceive('forceDelete')->andReturn(true);

        $response = $this->deleteJson('/api/faculties/10/force-delete');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
