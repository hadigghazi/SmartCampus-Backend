<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::get();
        return response()->json($students);
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->validated());
        return response()->json($student, 201);
    }

    public function show(Student $student)
    {
        return response()->json($student);
    }

    public function update(UpdateStudentRequest $request, $id)
    {
        $student = Student::findOrFail($id);
    
        $student->update($request->validated());
    
        return response()->json(['message' => 'Student updated successfully', 'student' => $student]);
    }
    
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $student = Student::withTrashed()->findOrFail($id);
        $student->restore();
        return response()->json($student);
    }

    public function forceDelete($id)
    {
        $student = Student::withTrashed()->findOrFail($id);
        $student->forceDelete();
        return response()->json(null, 204);
    }

    public function getStudentByUserId($userId)
    {
        try {
            $student = Student::where('user_id', $userId)->first();

            if (!$student) {
                return response()->json(['error' => 'Student not found'], 404);
            }

            return response()->json($student);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function getStudentsWithUserDetails()
{
    $students = Student::with('user:id,first_name,middle_name,last_name')->get();
    return response()->json($students);
}
}
