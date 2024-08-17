<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::withTrashed()->get();
        return response()->json($semesters);
    }

    public function store(StoreSemesterRequest $request)
    {
        $semester = Semester::create($request->validated());
        return response()->json($semester, 201);
    }

    public function show(Semester $semester)
    {
        return response()->json($semester);
    }

    public function update(UpdateSemesterRequest $request, Semester $semester)
    {
        $semester->update($request->validated());
        return response()->json($semester);
    }

}
