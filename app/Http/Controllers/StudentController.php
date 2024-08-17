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
        $students = Student::withTrashed()->get();
        return response()->json($students);
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->validated());
        return response()->json($student, 201);
    }

}
