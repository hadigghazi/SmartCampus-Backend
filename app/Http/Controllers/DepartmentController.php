<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withTrashed()->get();
        return response()->json($departments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
            'campus_id' => 'required|exists:campuses,id',
        ]);

        $department = Department::create($request->all());

        return response()->json($department, 201);
    }

    public function show(Department $department)
    {
        return response()->json($department);
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
            'campus_id' => 'required|exists:campuses,id',
        ]);

        $department->update($request->all());

        return response()->json($department);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $department = Department::withTrashed()->findOrFail($id);
        $department->restore();

        return response()->json($department);
    }

    public function forceDelete($id)
    {
        $department = Department::withTrashed()->findOrFail($id);
        $department->forceDelete();

        return response()->json(null, 204);
    }
}
