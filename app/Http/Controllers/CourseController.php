<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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


    function getAvailableCoursesForStudent()
    {
        $userId = auth()->id();

        $studentId = \App\Models\Student::where('user_id', $userId)->value('id');
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
    
        $response = $finalCourses->map(function ($course) {
            $prerequisiteCourses = CoursePrerequisite::where('course_id', $course->id)
                ->pluck('prerequisite_course_id')
                ->toArray();
    
            $prerequisiteCodes = Course::whereIn('id', $prerequisiteCourses)
                ->pluck('code')
                ->toArray();
    
            return [
                'course_id' => $course->id,
                'course_name' => $course->name,
                'course_code' => $course->code,
                'credits' => $course->credits,
                'prerequisites' => $prerequisiteCodes,
            ];
        });
    
        return $response->values()->toArray();
    }

    public function suggestCoursesForNextSemester()
    {
        $userId = auth()->id();
        $studentId = \App\Models\Student::where('user_id', $userId)->value('id');
        $student = \App\Models\Student::find($studentId);
    
        if (!$student) {
            throw new \Exception("Student not found");
        }
    
        $availableCourses = $this->getAvailableCoursesForStudent();
    
        $registeredCourses = \DB::table('registrations')
            ->join('course_instructors', 'registrations.course_instructor_id', '=', 'course_instructors.id')
            ->join('courses', 'course_instructors.course_id', '=', 'courses.id')
            ->leftJoin('grades', 'registrations.id', '=', 'grades.registration_id')
            ->where('registrations.student_id', $studentId)
            ->select('courses.name as course_name', 'courses.code as course_code', 'grades.grade')
            ->get();
    
        $courseList = collect($registeredCourses)->map(function ($course) {
            return "{$course->course_name} ({$course->course_code}) - Grade: {$course->grade}";
        })->implode(", ");
    
        $availableCourseList = collect($availableCourses)->map(function ($course) {
            return "{$course['course_name']} ({$course['course_code']}) - {$course['credits']} credits";
        })->implode(", ");
    
        $prompt = "Given the following courses available for a student to register for the next semester and their performance in previously completed courses, suggest a set of courses with a maximum total of 12 credits. Make the response talking to the student himself and add some explanations on why he should choose the course.";
        $prompt .= "Here is the list of previously completed courses and grades: $courseList. ";
        $prompt .= "Here is the list of available courses: $availableCourseList.";
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 2000,
            'temperature' => 0.7
        ]);
        
        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to get suggestions from the API.',
                'status' => $response->status(),
                'response' => $response->body()
            ], $response->status());
        }
    
        $responseJson = $response->json();
    
        $suggestions = $responseJson['choices'][0]['message']['content'] ?? null;
    
        return response()->json([
            'suggestions' => $suggestions
        ]);
    }
    
}
