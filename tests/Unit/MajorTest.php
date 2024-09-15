<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Major;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;

class MajorTest extends TestCase
{
    public function testIndex()
    {
        $majors = Mockery::mock(Collection::class);
        $majors->shouldReceive('get')->andReturn(collect([]));

        $majorModel = Mockery::mock(Major::class);
        $majorModel->shouldReceive('get')->andReturn($majors);

        $response = $this->getJson('/api/majors');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testStore()
    {
        $requestData = [
            'name' => 'Computer Science',
            'description' => 'CS major description',
            'faculty_id' => 1,
        ];

        $major = Mockery::mock(Major::class);
        $major->shouldReceive('create')->with($requestData)->andReturn($major);

        $response = $this->postJson('/api/majors', $requestData);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testShow()
    {
        $major = Mockery::mock(Major::class);
        $major->shouldReceive('findOrFail')->with(1)->andReturn($major);

        $response = $this->getJson('/api/majors/3');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdate()
    {
        $requestData = [
            'name' => 'Updated Major Name',
            'description' => 'Updated description',
            'faculty_id' => 2,
        ];

        $major = Mockery::mock(Major::class);
        $major->shouldReceive('findOrFail')->with(1)->andReturn($major);
        $major->shouldReceive('update')->with($requestData)->andReturn(true);

        $response = $this->putJson('/api/majors/3', $requestData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDestroy()
    {
        $major = Mockery::mock(Major::class);
        $major->shouldReceive('findOrFail')->with(1)->andReturn($major);
        $major->shouldReceive('delete')->andReturn(true);

        $response = $this->deleteJson('/api/majors/3');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testRestore()
    {
        $major = Mockery::mock(Major::class);
        $major->shouldReceive('withTrashed')->andReturnSelf();
        $major->shouldReceive('findOrFail')->with(1)->andReturn($major);
        $major->shouldReceive('restore')->andReturn(true);

        $response = $this->postJson('/api/majors/3/restore');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testForceDelete()
    {
        $major = Mockery::mock(Major::class);
        $major->shouldReceive('withTrashed')->andReturnSelf();
        $major->shouldReceive('findOrFail')->with(1)->andReturn($major);
        $major->shouldReceive('forceDelete')->andReturn(true);

        $response = $this->deleteJson('/api/majors/3/force-delete');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testGetMajorsByFaculty()
    {
        $majors = Mockery::mock(Collection::class);
        $majors->shouldReceive('where')->with('faculty_id', 1)->andReturnSelf();
        $majors->shouldReceive('get')->andReturn(collect([]));

        $response = $this->getJson('/api/majors/faculty/3');
        $response->assertStatus(Response::HTTP_OK);
    }
}
