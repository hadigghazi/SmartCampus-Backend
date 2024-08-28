<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Semester;
use App\Models\Registration;
use App\Http\Requests\StoreExam;
use App\Http\Requests\UpdateExam;

class ExamController extends Controller
{
    public function index()
    {
        $items = Exam::get();
        return response()->json($items);
    }

    public function store(StoreExam $request)
    {
        $item = Exam::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateExam $request, $id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }

    public function getCurrentSemester()
{
    return Semester::where('is_current', true)->first();
}

public function getExamsForStudent($studentId)
{
    $currentSemester = $this->getCurrentSemester();
    
    if (!$currentSemester) {
        return response()->json(['error' => 'No current semester found'], 404);
    }

    $registrations = Registration::with([
            'courseInstructor.course:id,code,name,credits',
            'courseInstructor.instructor.user:id,first_name,middle_name,last_name',
            'grade'
        ])
        ->where('student_id', $studentId)
        ->where('semester_id', $currentSemester->id)
        ->get();

    if ($registrations->isEmpty()) {
        return response()->json(['error' => 'No registrations found for the given student in the current semester'], 404);
    }

    $exams = $registrations->map(function ($registration) use ($currentSemester) {
        if (!$registration->courseInstructor) {
            return null; 
        }

        $courseInstructorId = $registration->courseInstructor->id;

        $exam = Exam::with([
                'room.block.campus',
                'courseInstructor.instructor.user'
            ])
            ->where('course_instructor_id', $courseInstructorId)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$exam || $exam->courseInstructor->semester_id !== $currentSemester->id) {
            return null; 
        }

        $room = $exam->room;
        $block = $room ? $room->block : null; 
        $campus = $block ? $block->campus : null; 
        $semester = $exam->courseInstructor->semester;
        $courseInstructor = $exam->courseInstructor;
        $instructor = $courseInstructor ? $courseInstructor->instructor : null;
        $user = $instructor ? $instructor->user : null; 

        $courseName = $courseInstructor->course->name ?? 'N/A';
        $courseCode = $courseInstructor->course->code ?? 'N/A';
        $roomNumber = $room->number ?? 'N/A';
        $blockName = $block->name ?? 'N/A';
        $campusName = $campus->name ?? 'N/A';
        $semesterName = $semester->name ?? 'N/A';
        $instructorName = $user 
            ? trim("{$user->first_name} {$user->middle_name} {$user->last_name}")
            : 'N/A';

        return [
            'id' => $exam->id,
            'course_name' => $courseName,
            'course_code' => $courseCode,
            'date' => $exam->date,
            'time' => $exam->time,
            'duration' => $exam->duration,
            'room_number' => $roomNumber,
            'block_name' => $blockName,
            'campus_name' => $campusName,
            'semester_name' => $semesterName,
            'instructor_name' => $instructorName,
            'created_at' => $exam->created_at,
            'updated_at' => $exam->updated_at,
            'deleted_at' => $exam->deleted_at,
        ];
    })->filter(); 

    if ($exams->isEmpty()) {
        return response()->json(['error' => 'No exams found for the given student in the current semester'], 404);
    }

    return response()->json($exams->values());
}


    public function getExamDetails($courseInstructorId)
    {
        $exam = Exam::with([
                'room.block.campus',
                'semester',
                'courseInstructor.instructor.user'
            ])
            ->whereHas('courseInstructor', function ($query) use ($courseInstructorId) {
                $query->where('id', $courseInstructorId);
            })
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->first();
    
        if (!$exam) {
            return response()->json(['error' => 'No exams found for the given course instructor ID'], 404);
        }
    
        $room = $exam->room;
        $block = $room ? $room->block : null; 
        $campus = $block ? $block->campus : null; 
        $semester = $exam->semester;
        $courseInstructor = $exam->courseInstructor;
        $instructor = $courseInstructor ? $courseInstructor->instructor : null;
        $user = $instructor ? $instructor->user : null; 
    
        $courseName = $courseInstructor->course->name ?? 'N/A';
        $courseCode = $courseInstructor->course->code ?? 'N/A';
        $roomNumber = $room->number ?? 'N/A';
        $blockName = $block->name ?? 'N/A';
        $campusName = $campus->name ?? 'N/A';
        $semesterName = $semester->name ?? 'N/A';
        $instructorName = $user 
            ? trim("{$user->first_name} {$user->middle_name} {$user->last_name}")
            : 'N/A';
    
        $examDetails = [
            'id' => $exam->id,
            'course_name' => $courseName,
            'course_code' => $courseCode,
            'date' => $exam->date,
            'time' => $exam->time,
            'duration' => $exam->duration,
            'room_number' => $roomNumber,
            'block_name' => $blockName,
            'campus_name' => $campusName,
            'semester_name' => $semesterName,
            'instructor_name' => $instructorName,
            'created_at' => $exam->created_at,
            'updated_at' => $exam->updated_at,
            'deleted_at' => $exam->deleted_at,
        ];
    
        return response()->json($examDetails);
    }
    
    
    

    public function getAllExams()
    {
        try {
            $exams = Exam::with([
                'course',
                'room.block.campus' 
            ])->get();
    
            $examDetails = $exams->map(function($exam) {
                if ($exam->trashed()) {
                    return null; 
                }
    
                $courseName = $exam->course ? $exam->course->name : 'N/A';
                $roomNumber = $exam->room ? $exam->room->number : 'N/A';
                $blockName = $exam->room && $exam->room->block ? $exam->room->block->name : 'N/A';
                $campusName = $exam->room && $exam->room->block && $exam->room->block->campus ? $exam->room->block->campus->name : 'N/A';
    
                return [
                    'id' => $exam->id,
                    'course_name' => $courseName,
                    'date' => $exam->date,
                    'time' => $exam->time,
                    'duration' => $exam->duration,
                    'room_number' => $roomNumber,
                    'block_name' => $blockName,
                    'campus_name' => $campusName,
                    'created_at' => $exam->created_at,
                    'updated_at' => $exam->updated_at,
                    'deleted_at' => $exam->deleted_at,
                ];
            })->filter(); 
            return response()->json($examDetails);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }
}
