<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::all();
        return response()->json($fees);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'nullable|exists:courses,id',
            'description' => 'required|string',
            'amount_usd' => 'required|numeric',
            'amount_lbp' => 'required|numeric',
        ]);

        $fee = Fee::create($request->all());
        return response()->json($fee, 201);
    }

    public function show(Fee $fee)
    {
        return response()->json($fee);
    }

    public function update(Request $request, Fee $fee)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'nullable|exists:courses,id',
            'description' => 'required|string',
            'amount_usd' => 'required|numeric',
            'amount_lbp' => 'required|numeric',
        ]);

        $fee->update($request->all());
        return response()->json($fee);
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $fee = Fee::withTrashed()->findOrFail($id);
        $fee->restore();
        return response()->json($fee);
    }

    public function forceDelete($id)
    {
        $fee = Fee::withTrashed()->findOrFail($id);
        $fee->forceDelete();
        return response()->json(null, 204);
    }
}
