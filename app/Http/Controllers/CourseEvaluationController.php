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
                'teaching' => [
                    'quality' => $this->mapEvaluation($evaluation->teaching_number),
                    'feedback' => $evaluation->teaching,
                ],
                'course_content' => [
                    'quality' => $this->mapEvaluation($evaluation->coursecontent_number),
                    'feedback' => $evaluation->coursecontent,
                ],
                'examination' => [
                    'quality' => $this->mapEvaluation($evaluation->examination_number),
                    'feedback' => $evaluation->examination,
                ],
                'labwork' => [
                    'quality' => $this->mapEvaluation($evaluation->labwork_number),
                    'feedback' => $evaluation->labwork,
                ],
                'library_facilities' => [
                    'quality' => $this->mapEvaluation($evaluation->library_facilities_number),
                    'feedback' => $evaluation->library_facilities,
                ],
                'extracurricular' => [
                    'quality' => $this->mapEvaluation($evaluation->extracurricular_number),
                    'feedback' => $evaluation->extracurricular,
                ],
            ];
        });
    
        $prompt = "You are tasked with conducting a professional and in-depth analysis of the following student evaluations for a course, which has been marked as {$request->status}. 
        The course evaluations include both qualitative feedback and a rating (Good, Average, or Bad) for various aspects: Teaching, Course Content, Examination, Labwork, Library Facilities, and Extracurricular activities.

        Your objective is to:
        1. Provide a thorough, professional evaluation of the course's strengths and weaknesses, not just by listing the feedback, but by identifying patterns, trends, and areas for meaningful improvement.
        2. Consider the relationship between the qualitative feedback and the ratings (Good, Average, Bad) provided by students. Evaluate whether the text feedback aligns with the ratings given, or if there are inconsistencies that suggest either exaggeration or understatement.
        3. Analyze differing opinions from students and assess whether these indicate deeper issues in the course structure or individual student biases.
        4. Offer actionable suggestions for improvement, whether the course was marked as Successful or Unsuccessful, with a focus on addressing root causes rather than surface-level concerns.
        5. Assess the overall fairness and honesty of the evaluations based on the diversity of opinions, consistency in feedback, and the balance of positive versus negative comments. Determine whether the status of the course (Successful or Unsuccessful) is justified by the student evaluations.

        Please provide a nuanced, thoughtful analysis that looks beyond individual comments, focusing on the collective student feedback, identifying the core issues, and suggesting well-reasoned improvements for future iterations of the course.\n\n";

        foreach ($mappedEvaluations as $index => $eval) {
            $prompt .= "Evaluation " . ($index + 1) . ":\n";
            $prompt .= "Teaching: {$eval['teaching']['quality']} (Feedback: {$eval['teaching']['feedback']})\n";
            $prompt .= "Course Content: {$eval['course_content']['quality']} (Feedback: {$eval['course_content']['feedback']})\n";
            $prompt .= "Examination: {$eval['examination']['quality']} (Feedback: {$eval['examination']['feedback']})\n";
            $prompt .= "Labwork: {$eval['labwork']['quality']} (Feedback: {$eval['labwork']['feedback']})\n";
            $prompt .= "Library Facilities: {$eval['library_facilities']['quality']} (Feedback: {$eval['library_facilities']['feedback']})\n";
            $prompt .= "Extracurricular: {$eval['extracurricular']['quality']} (Feedback: {$eval['extracurricular']['feedback']})\n\n";
        }
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an expert in analyzing educational evaluations.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 5000,
            'temperature' => 0.7,
        ]);
    
        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to get analysis from OpenAI API.',
                'status' => $response->status(),
                'response' => $response->body(),
            ], $response->status());
        }
    
        $analysis = $response->json()['choices'][0]['message']['content'] ?? null;
    
        return response()->json([
            'analysis' => $analysis,
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