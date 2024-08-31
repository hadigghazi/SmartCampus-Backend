<?php

namespace App\Http\Controllers;

use App\Models\CourseInstructor;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Registration;
use App\Models\Campus;
use App\Models\Semester;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseInstructorRequest;
use App\Http\Requests\UpdateCourseInstructorRequest;

class CourseInstructorController extends Controller
{
    public function index()
    {
        $courseInstructors = CourseInstructor::get();
        return response()->json($courseInstructors);
    }

    public function store(StoreCourseInstructorRequest $request)
    {
        $courseInstructor = CourseInstructor::create($request->validated());
        return response()->json($courseInstructor, 201);
    }

    public function show(CourseInstructor $courseInstructor)
    {
        return response()->json($courseInstructor);
    }

    public function update(UpdateCourseInstructorRequest $request, CourseInstructor $courseInstructor)
    {
        $courseInstructor->update($request->validated());
        return response()->json($courseInstructor);
    }

    public function destroy(CourseInstructor $courseInstructor)
    {
        $courseInstructor->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $courseInstructor = CourseInstructor::withTrashed()->findOrFail($id);
        $courseInstructor->restore();
        return response()->json($courseInstructor);
    }

    public function forceDelete($id)
    {
        $courseInstructor = CourseInstructor::withTrashed()->findOrFail($id);
        $courseInstructor->forceDelete();
        return response()->json(null, 204);
    }

    public function getCourseOptions($id)
    {
        $courseOptions = CourseInstructor::where('course_id', $id)
            ->with('instructor.user', 'campus', 'semester', 'room.block') 
            ->get()
            ->map(function ($courseInstructor) {
                $user = $courseInstructor->instructor->user;
                $room = $courseInstructor->room;
                $block = $room ? $room->block : null;
    
                return [
                    'id' => $courseInstructor->id,
                    'instructor_name' => $user ? "{$user->first_name} {$user->middle_name} {$user->last_name}" : 'Unknown',
                    'campus_name' => $courseInstructor->campus->name,
                    'schedule' => $this->formatSchedule($courseInstructor->schedule),
                    'available_seats' => $courseInstructor->capacity,
                    'semester_name' => $courseInstructor->semester->name,
                    'room' => $block ? "{$block->name} - Room {$room->number}" : 'Unknown Room',
                ];
            });
    
        return response()->json($courseOptions);
    }
    
    private function formatSchedule($schedule)
    {
        return $schedule;
    }
    
    public function getAssignedCourses($id)
{
    $courses = CourseInstructor::where('instructor_id', $id)->get();
    return response()->json($courses);
}

public function getCoursesForInstructor($id)
{
    $courses = CourseInstructor::where('instructor_id', $id)
        ->with('course', 'campus', 'semester', 'room.block')
        ->get()
        ->map(function ($courseInstructor) {
            $course = $courseInstructor->course;
            $campus = $courseInstructor->campus;
            $semester = $courseInstructor->semester;
            $room = $courseInstructor->room;
            $block = $room ? $room->block : null;
            $numberOfStudents = Registration::where('course_instructor_id', $courseInstructor->id)
            ->whereNull('deleted_at')
            ->count();

            return [
                'id' => $courseInstructor->id,
                'course_id' => $courseInstructor->course_id,
                'course_code' => $course ? $course->code : 'Unknown Course Code',
                'course_name' => $course ? $course->name : 'Unknown Course',
                'credits' => $course ? $course->credits : 'Unknown Credits',
                'campus_name' => $campus ? $campus->name : 'Unknown Campus',
                'semester_name' => $semester ? $semester->name : 'Unknown Semester',
                'semester_id' => $semester ? $semester->id : 'Unknown Semester',
                'from_date' => $semester ? $semester->start_date : 'Unknown Start Date',
                'to_date' => $semester ? $semester->end_date : 'Unknown End Date',
                'room' => $block ? "Block {$block->name} - Room {$room->number}" : 'Unknown Room',
                'schedule' => $this->formatSchedule($courseInstructor->schedule),
                'available_seats' => $courseInstructor->capacity,
                'number_of_students' => $numberOfStudents,
            ];
        });

    return response()->json($courses);
}

public function getCourseDetails($courseInstructorId)
{
    $courseInstructor = CourseInstructor::find($courseInstructorId);

    if (!$courseInstructor) {
        return response()->json(['message' => 'Course Instructor not found.'], 404);
    }

    $course = Course::find($courseInstructor->course_id);

    if (!$course) {
        return response()->json(['message' => 'Course not found.'], 404);
    }

    return response()->json([
        'course_code' => $course->code,
        'course_name' => $course->name,
    ]);
}

}
