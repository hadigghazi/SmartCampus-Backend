<?php

namespace App\Http\Controllers;

use App\Models\CourseEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseEvaluationController extends Controller
{
    public function index()
    {
        $evaluations = CourseEvaluation::all();
        return response()->json($evaluations);
    }

    public function show($id)
    {
        $evaluation = CourseEvaluation::find($id);

        if (!$evaluation) {
            return response()->json(['message' => 'Evaluation not found'], 404);
        }

        return response()->json($evaluation);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teaching_number' => 'required|integer',
            'teaching' => 'required|string',
            'coursecontent_number' => 'required|integer',
            'coursecontent' => 'required|string',
            'examination_number' => 'required|integer',
            'examination' => 'required|string',
            'labwork_number' => 'required|integer',
            'labwork' => 'required|string',
            'library_facilities_number' => 'required|integer',
            'library_facilities' => 'required|string',
            'extracurricular_number' => 'required|integer',
            'extracurricular' => 'required|string',
            'course_instructor_id' => 'required|exists:course_instructors,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $evaluation = CourseEvaluation::create($request->all());
        return response()->json($evaluation, 201);
    }

    public function update(Request $request, $id)
    {
        $evaluation = CourseEvaluation::find($id);

        if (!$evaluation) {
            return response()->json(['message' => 'Evaluation not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'teaching_number' => 'required|integer',
            'teaching' => 'required|string',
            'coursecontent_number' => 'required|integer',
            'coursecontent' => 'required|string',
            'examination_number' => 'required|integer',
            'examination' => 'required|string',
            'labwork_number' => 'required|integer',
            'labwork' => 'required|string',
            'library_facilities_number' => 'required|integer',
            'library_facilities' => 'required|string',
            'extracurricular_number' => 'required|integer',
            'extracurricular' => 'required|string',
            'course_instructor_id' => 'required|exists:course_instructors,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $evaluation->update($request->all());
        return response()->json($evaluation);
    }

    public function destroy($id)
    {
        $evaluation = CourseEvaluation::find($id);

        if (!$evaluation) {
            return response()->json(['message' => 'Evaluation not found'], 404);
        }

        $evaluation->delete();
        return response()->json(['message' => 'Evaluation deleted successfully']);
    }

    public function restore($id)
    {
        $courseEvaluation = CourseEvaluation::withTrashed()->findOrFail($id);
        $courseEvaluation->restore();
        return response()->json($courseEvaluation);
    }

    public function forceDelete($id)
    {
        $courseEvaluation = CourseEvaluation::withTrashed()->findOrFail($id);
        $courseEvaluation->forceDelete();
        return response()->json(null, 204);
    }

}
