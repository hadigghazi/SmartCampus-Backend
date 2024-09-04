<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Registration;
use App\Models\CoursePrerequisite;
use App\Models\CourseInstructor;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::get();
        return response()->json($courses);
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->validated());
        return response()->json($course, 201);
    }

    public function show(Course $course)
    {
        $course->load('major', 'faculty', 'exams', 'courseInstructors', 'prerequisites', 'prerequisiteCourses', 'assignments', 'courseMaterials', 'courseDropRequests');
        return response()->json($course);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());
        return response()->json($course);
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        $course->restore();
        return response()->json($course);
    }

    public function forceDelete($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        $course->forceDelete();
        return response()->json(null, 204);
    }

    public function getCoursesByFaculty($facultyId)
    {
        $courses = Course::where('faculty_id', $facultyId)->get();
        return response()->json($courses);
    }

    public function getCoursesByMajor($majorId)
    {
        $courses = Course::where('major_id', $majorId)->get();
        return response()->json($courses);
    }


    function getAvailableCoursesForStudent($studentId)
    {
        $student = \App\Models\Student::find($studentId);
        if (!$student) {
            throw new \Exception("Student not found");
        }
    
        $majorId = $student->major_id;
    
        $allCoursesInMajor = Course::where('major_id', $majorId)->get();
    
        $completedCourseIds = Registration::where('student_id', $studentId)
            ->where('status', 'Completed')
            ->pluck('course_instructor_id')
            ->map(function($courseInstructorId) {
                return CourseInstructor::find($courseInstructorId)->course_id;
            })
            ->toArray();
    
        $availableCourses = $allCoursesInMajor->filter(function ($course) use ($completedCourseIds) {
            return !in_array($course->id, $completedCourseIds);
        });
    
        $finalCourses = $availableCourses->filter(function ($course) use ($studentId, $completedCourseIds) {
            $prerequisites = CoursePrerequisite::where('course_id', $course->id)->get();
    
            foreach ($prerequisites as $prerequisite) {
                if (!in_array($prerequisite->prerequisite_course_id, $completedCourseIds)) {
                    return false;
                }
            }
    
            return true;
        });
    
        return $finalCourses;
    }
}
