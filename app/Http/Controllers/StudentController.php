<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StudentRequest;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::withTrashed()->get();
        return response()->json($students);
    }

    public function show(Student $student)
    {
        $student = Student::withTrashed()->findOrFail($student->id);
        return response()->json($student);
    }

    public function store(StudentRequest $request)
    {
        $student = Student::create($request->validated());
        return response()->json($student, 201);
    }

    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->validated());
        return response()->json($student);
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
}
