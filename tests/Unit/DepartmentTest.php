<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Department;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DepartmentTest extends TestCase
{
    public function testIndex()
    {
        $departments = Mockery::mock(Collection::class);
        $departments->shouldReceive('all')->andReturn(collect([]));

        $departmentModel = Mockery::mock(Department::class);
        $departmentModel->shouldReceive('all')->andReturn($departments);

        $response = $this->getJson('/api/departments');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testStore()
    {
        $requestData = [
            'name' => 'New Department',
            'description' => 'Department description',
        ];

        $department = Mockery::mock(Department::class);
        $department->shouldReceive('create')->with($requestData)->andReturn($department);

        $response = $this->postJson('/api/departments', $requestData);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testShow()
    {
        $department = Mockery::mock(Department::class);
        $department->shouldReceive('findOrFail')->with(1)->andReturn($department);

        $response = $this->getJson('/api/departments/1');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdate()
    {
        $requestData = [
            'name' => 'Updated Department',
            'description' => 'Updated description',
        ];

        $department = Mockery::mock(Department::class);
        $department->shouldReceive('findOrFail')->with(1)->andReturn($department);
        $department->shouldReceive('update')->with($requestData)->andReturn(true);

        $response = $this->putJson('/api/departments/1', $requestData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDestroy()
    {
        $department = Mockery::mock(Department::class);
        $department->shouldReceive('findOrFail')->with(1)->andReturn($department);
        $department->shouldReceive('delete')->andReturn(true);

        $response = $this->deleteJson('/api/departments/1');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testRestore()
    {
        $department = Mockery::mock(Department::class);
        $department->shouldReceive('findOrFail')->with(1)->andReturn($department);
        $department->shouldReceive('restore')->andReturn(true);

        $response = $this->postJson('/api/departments/1/restore');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testForceDelete()
    {
        $department = Mockery::mock(Department::class);
        $department->shouldReceive('findOrFail')->with(1)->andReturn($department);
        $department->shouldReceive('forceDelete')->andReturn(true);

        $response = $this->deleteJson('/api/departments/1/force-delete');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
