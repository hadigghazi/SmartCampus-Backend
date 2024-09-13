<?php

namespace App\Http\Controllers;

use App\Models\CourseEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


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
            'student_id' => 'required|exists:students,id',
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

        $existingEvaluation = CourseEvaluation::where('student_id', $request->student_id)
            ->where('course_instructor_id', $request->course_instructor_id)
            ->first();

        if ($existingEvaluation) {
            $existingEvaluation->update($request->all());
            return response()->json($existingEvaluation, 200);
        } else {
            $evaluation = CourseEvaluation::create($request->all());
            return response()->json($evaluation, 201);
        }
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
        return response()->json($evaluation, 200);
    }

    public function destroy($id)
    {
        $evaluation = CourseEvaluation::find($id);

        if (!$evaluation) {
            return response()->json(['message' => 'Evaluation not found'], 404);
        }

        $evaluation->delete();
        return response()->json(['message' => 'Evaluation deleted successfully'], 200);
    }

    public function restore($id)
    {
        $courseEvaluation = CourseEvaluation::withTrashed()->findOrFail($id);
        $courseEvaluation->restore();
        return response()->json($courseEvaluation, 200);
    }

    public function forceDelete($id)
    {
        $courseEvaluation = CourseEvaluation::withTrashed()->findOrFail($id);
        $courseEvaluation->forceDelete();
        return response()->json(null, 204);
    }

    public function getByInstructor($courseInstructorId)
    {
        $evaluations = CourseEvaluation::where('course_instructor_id', $courseInstructorId)->get();

        if ($evaluations->isEmpty()) {
            return response()->json(['message' => 'No evaluations found for this instructor'], 404);
        }

        return response()->json($evaluations);
    }

    public function analyzeCourseInstructor(Request $request)
{
    $validator = Validator::make($request->all(), [
        'course_instructor_id' => 'required|exists:course_instructors,id',
        'status' => 'required|in:Successful,Unsuccessful'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $evaluations = CourseEvaluation::where('course_instructor_id', $request->course_instructor_id)->get();

    if ($evaluations->isEmpty()) {
        return response()->json(['message' => 'No evaluations found for this instructor'], 404);
    }

    $mappedEvaluations = $evaluations->map(function ($evaluation) {
        return [
            'teaching' => $evaluation->teaching,
            'teaching_quality' => $this->mapEvaluation($evaluation->teaching_number),
            'course_content' => $evaluation->coursecontent,
            'course_content_quality' => $this->mapEvaluation($evaluation->coursecontent_number),
            'examination' => $evaluation->examination,
            'examination_quality' => $this->mapEvaluation($evaluation->examination_number),
            'labwork' => $evaluation->labwork,
            'labwork_quality' => $this->mapEvaluation($evaluation->labwork_number),
            'library_facilities' => $evaluation->library_facilities,
            'library_facilities_quality' => $this->mapEvaluation($evaluation->library_facilities_number),
            'extracurricular' => $evaluation->extracurricular,
            'extracurricular_quality' => $this->mapEvaluation($evaluation->extracurricular_number),
        ];
    });

    $prompt = "Analyze the following evaluations for a course instructor. The course has been marked as {$request->status}. 
        The evaluation scores are given on a scale where -1 is Bad, 0 is Average, and 1 is Good. 
        If the course is marked as UnSuccessful, analyze why it failed and suggest improvements. 
        If it's Successful, highlight the good aspects and suggest areas for improvement.\n\n";

    foreach ($mappedEvaluations as $eval) {
        $prompt .= "Teaching: {$eval['teaching']} (Quality: {$eval['teaching_quality']})\n";
        $prompt .= "Course Content: {$eval['course_content']} (Quality: {$eval['course_content_quality']})\n";
        $prompt .= "Examination: {$eval['examination']} (Quality: {$eval['examination_quality']})\n";
        $prompt .= "Labwork: {$eval['labwork']} (Quality: {$eval['labwork_quality']})\n";
        $prompt .= "Library Facilities: {$eval['library_facilities']} (Quality: {$eval['library_facilities_quality']})\n";
        $prompt .= "Extracurricular: {$eval['extracurricular']} (Quality: {$eval['extracurricular_quality']})\n\n";
    }

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
    ])->post('https://api.openai.com/v1/chat/completions', [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'system', 'content' => 'You are an expert educational evaluator.'],
            ['role' => 'user', 'content' => $prompt],
        ],
        'max_tokens' => 2000,
        'temperature' => 0.7
    ]);

    if ($response->failed()) {
        return response()->json([
            'error' => 'Failed to get analysis from OpenAI API.',
            'status' => $response->status(),
            'response' => $response->body()
        ], $response->status());
    }

    $analysis = $response->json()['choices'][0]['message']['content'] ?? null;
    
    return response()->json([
        'analysis' => $eval
    ]);
}

private function mapEvaluation($number)
{
    switch ($number) {
        case -1:
            return 'Bad';
        case 0:
            return 'Average';
        case 1:
            return 'Good';
        default:
            return 'Unknown';
    }
}

}
