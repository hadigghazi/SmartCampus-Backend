<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Course;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;

class CourseTest extends TestCase
{
    public function testIndex()
    {
        $courses = Mockery::mock(Collection::class);
        $courses->shouldReceive('get')->andReturn(collect([]));

        $courseModel = Mockery::mock(Course::class);
        $courseModel->shouldReceive('get')->andReturn($courses);

        $response = $this->getJson('/api/courses');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testStore()
    {
        $requestData = [
            'code' => 'CS1e0w01',
            'name' => 'Intro to Science',
            'description' => 'Introduction course',
            'credits' => 3,
            'major_id' => 1,  
            'faculty_id' => 1,  
        ];

        $course = Mockery::mock(Course::class);
        $course->shouldReceive('create')->with($requestData)->andReturn($course);

        $response = $this->postJson('/api/courses', $requestData);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testShow()
    {
        $course = Mockery::mock(Course::class);
        $course->shouldReceive('load')
            ->with('major', 'faculty', 'courseInstructors', 'prerequisites', 'prerequisiteCourses')
            ->andReturn($course);

        $response = $this->getJson('/api/courses/11');  
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdate()
    {
        $requestData = [
            'code' => 'CS1-02',
            'name' => 'Advanced Computer Science',
            'description' => 'Advanced concepts',
            'credits' => 4,
            'major_id' => 1, 
            'faculty_id' => 1,  
        ];

        $course = Mockery::mock(Course::class);
        $course->shouldReceive('findOrFail')->with(11)->andReturn($course);  
        $course->shouldReceive('update')->with($requestData)->andReturn(true);

        $response = $this->putJson('/api/courses/11', $requestData);  
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDestroy()
    {
        $course = Mockery::mock(Course::class);
        $course->shouldReceive('findOrFail')->with(11)->andReturn($course);  
        $course->shouldReceive('delete')->andReturn(true);

        $response = $this->deleteJson('/api/courses/11');  
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testRestore()
    {
        $course = Mockery::mock(Course::class);
        $course->shouldReceive('withTrashed')->andReturnSelf();
        $course->shouldReceive('findOrFail')->with(11)->andReturn($course);  
        $course->shouldReceive('restore')->andReturn(true);

        $response = $this->postJson('/api/courses/11/restore');  
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testForceDelete()
    {
        $course = Mockery::mock(Course::class);
        $course->shouldReceive('withTrashed')->andReturnSelf();
        $course->shouldReceive('findOrFail')->with(11)->andReturn($course);  
        $course->shouldReceive('forceDelete')->andReturn(true);

        $response = $this->deleteJson('/api/courses/11/force-delete');  
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testGetCoursesByFaculty()
    {
        $courses = Mockery::mock(Collection::class);
        $courses->shouldReceive('where')->with('faculty_id', 1)->andReturnSelf();  
        $courses->shouldReceive('get')->andReturn(collect([]));

        $response = $this->getJson('/api/courses/faculty/1');  
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testGetCoursesByMajor()
    {
        $courses = Mockery::mock(Collection::class);
        $courses->shouldReceive('where')->with('major_id', 1)->andReturnSelf();  
        $courses->shouldReceive('get')->andReturn(collect([]));

        $response = $this->getJson('/api/courses/major/1');  
        $response->assertStatus(Response::HTTP_OK);
    }
}
