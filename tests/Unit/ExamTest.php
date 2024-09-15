<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Exam;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;

class ExamTest extends TestCase
{
    public function testIndex()
    {
        $exams = Mockery::mock(Collection::class);
        $exams->shouldReceive('get')->andReturn(collect([]));

        $examModel = Mockery::mock(Exam::class);
        $examModel->shouldReceive('get')->andReturn($exams);

        $response = $this->getJson('/api/exams');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testStore()
    {
        $requestData = [
            'course_instructor_id' => 1,
            'date' => '2024-09-01',
            'time' => '10:00:00',
            'duration' => 120,
            'campus_id' => 2,
            'room_id' => 4
        ];

        $exam = Mockery::mock(Exam::class);
        $exam->shouldReceive('create')->with($requestData)->andReturn($exam);

        $response = $this->postJson('/api/exams', $requestData);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testShow()
    {
        $exam = Mockery::mock(Exam::class);
        $exam->shouldReceive('findOrFail')->with(10)->andReturn($exam);

        $response = $this->getJson('/api/exams/10');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdate()
    {
        $requestData = [
            'course_instructor_id' => 1,
            'date' => '2024-010-01',
            'time' => '11:00:00',
            'duration' => 100,
            'campus_id' => 2,
            'room_id' => 4
        ];

        $exam = Mockery::mock(Exam::class);
        $exam->shouldReceive('findOrFail')->with(10)->andReturn($exam);
        $exam->shouldReceive('update')->with($requestData)->andReturn(true);

        $response = $this->putJson('/api/exams/10', $requestData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDestroy()
    {
        $exam = Mockery::mock(Exam::class);
        $exam->shouldReceive('findOrFail')->with(10)->andReturn($exam);
        $exam->shouldReceive('delete')->andReturn(true);

        $response = $this->deleteJson('/api/exams/10');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testRestore()
    {
        $exam = Mockery::mock(Exam::class);
        $exam->shouldReceive('withTrashed')->andReturnSelf();
        $exam->shouldReceive('findOrFail')->with(10)->andReturn($exam);
        $exam->shouldReceive('restore')->andReturn(true);

        $response = $this->postJson('/api/exams/10/restore');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testForceDelete()
    {
        $exam = Mockery::mock(Exam::class);
        $exam->shouldReceive('withTrashed')->andReturnSelf();
        $exam->shouldReceive('findOrFail')->with(10)->andReturn($exam);
        $exam->shouldReceive('forceDelete')->andReturn(true);

        $response = $this->deleteJson('/api/exams/10/force-delete');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testGetAllExamDetails()
    {
        $exams = Mockery::mock(Collection::class);
        $exams->shouldReceive('get')->andReturn(collect([]));

        $response = $this->getJson('/api/get_exam_details');
        $response->assertStatus(Response::HTTP_OK);
    }
}
