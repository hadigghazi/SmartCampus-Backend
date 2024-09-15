<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Semester;
use App\Models\Registration;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class SemesterTest extends TestCase
{
    public function testIndex()
    {
        $semesters = Mockery::mock(Collection::class);
        $semesters->shouldReceive('all')->andReturn(collect([]));

        $semesterModel = Mockery::mock(Semester::class);
        $semesterModel->shouldReceive('all')->andReturn($semesters);

        $response = $this->getJson('/api/semesters');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testStore()
    {
        $requestData = [
            'name' => 'Fall 2024',
            'start_date' => '2024-09-01',
            'end_date' => '2024-12-15',
            'is_current' => true
        ];

        $semester = Mockery::mock(Semester::class);
        $semester->shouldReceive('create')->with($requestData)->andReturn($semester);

        $response = $this->postJson('/api/semesters', $requestData);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testShow()
    {
        $semester = Mockery::mock(Semester::class);
        $semester->shouldReceive('findOrFail')->with(5)->andReturn($semester);

        $response = $this->getJson('/api/semesters/5');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdate()
    {
        $requestData = [
            'name' => 'Spring 2025',
            'start_date' => '2025-01-01',
            'end_date' => '2025-05-15',
            'is_current' => false
        ];

        $semester = Mockery::mock(Semester::class);
        $semester->shouldReceive('findOrFail')->with(5)->andReturn($semester);
        $semester->shouldReceive('update')->with($requestData)->andReturn(true);

        $response = $this->putJson('/api/semesters/5', $requestData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDestroy()
    {
        $semester = Mockery::mock(Semester::class);
        $semester->shouldReceive('findOrFail')->with(5)->andReturn($semester);
        $semester->shouldReceive('delete')->andReturn(true);

        $response = $this->deleteJson('/api/semesters/5');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testRestore()
    {
        $semester = Mockery::mock(Semester::class);
        $semester->shouldReceive('withTrashed')->andReturnSelf();
        $semester->shouldReceive('findOrFail')->with(5)->andReturn($semester);
        $semester->shouldReceive('restore')->andReturn(true);

        $response = $this->postJson('/api/semesters/5/restore');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testForceDelete()
    {
        $semester = Mockery::mock(Semester::class);
        $semester->shouldReceive('withTrashed')->andReturnSelf();
        $semester->shouldReceive('findOrFail')->with(5)->andReturn($semester);
        $semester->shouldReceive('forceDelete')->andReturn(true);

        $response = $this->deleteJson('/api/semesters/5/force-delete');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testGetCurrentSemester()
    {
        $semester = Mockery::mock(Semester::class);
        $semester->shouldReceive('where')
            ->with('is_current', true)
            ->andReturnSelf();
        $semester->shouldReceive('first')->andReturn($semester);

        $response = $this->getJson('/api/semester/current');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testGetSemestersForStudent()
    {
        $studentId = 1;
        $semesterIds = collect([1, 2, 3]);

        $registrations = Mockery::mock(Collection::class);
        $registrations->shouldReceive('distinct')->andReturnSelf();
        $registrations->shouldReceive('pluck')->with('semester_id')->andReturn($semesterIds);

        $registrationModel = Mockery::mock(Registration::class);
        $registrationModel->shouldReceive('where')->with('student_id', $studentId)->andReturn($registrations);

        $semesters = Mockery::mock(Collection::class);
        $semesters->shouldReceive('whereIn')->with('id', $semesterIds)->andReturnSelf();
        $semesters->shouldReceive('get')->with(['id', 'name'])->andReturn($semesters);

        $response = $this->getJson("/api/semesters_by_student/{$studentId}");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testGetSemestersForInstructor()
    {
        $instructorId = 1;
        $semesters = collect([
            ['id' => 1, 'name' => 'Fall 2024'],
            ['id' => 2, 'name' => 'Spring 2025']
        ]);

        DB::shouldReceive('table')
            ->with('course_instructors')
            ->andReturnSelf();
        DB::shouldReceive('join')
            ->with('semesters', 'course_instructors.semester_id', '=', 'semesters.id')
            ->andReturnSelf();
        DB::shouldReceive('where')
            ->with('course_instructors.instructor_id', $instructorId)
            ->andReturnSelf();
        DB::shouldReceive('select')
            ->with('semesters.id', 'semesters.name')
            ->andReturnSelf();
        DB::shouldReceive('distinct')->andReturnSelf();
        DB::shouldReceive('orderBy')
            ->with('semesters.created_at', 'desc')
            ->andReturnSelf();
        DB::shouldReceive('get')->andReturn($semesters);

        $response = $this->getJson("/api/semesters_by_instructor/{$instructorId}");
        $response->assertStatus(Response::HTTP_OK);
    }
}
