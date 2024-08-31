<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Assignment;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function store(Request $request, $assignmentId)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:pdf,docx,pptx,zip|max:20480',
        ]);

        if (!Assignment::find($assignmentId)) {
            return response()->json(['error' => 'Assignment not found.'], 404);
        }

        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }

        $student = Student::where('user_id', $userId)->first();

        if (!$student) {
            return response()->json(['error' => 'Student record not found.'], 404);
        }

        $studentId = $student->id;
        $submissionDate = now();
        $filePaths = [];

        foreach ($request->file('files') as $file) {
            $filePaths[] = $file->store('submissions', 'public');
        }

        Submission::where('assignment_id', $assignmentId)
                  ->where('student_id', $studentId)
                  ->delete();

        foreach ($filePaths as $filePath) {
            Submission::create([
                'assignment_id' => $assignmentId,
                'student_id' => $studentId,
                'file_path' => $filePath,
                'submission_date' => $submissionDate,
            ]);
        }

        return response()->json(['message' => 'Files submitted successfully.'], 201);
    }

    public function index($assignmentId)
    {
        $userId = Auth::id();
    
        $student = Student::where('user_id', $userId)->first();
        
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    
        $studentId = $student->id;
    
        $submissions = Submission::where('assignment_id', $assignmentId)
            ->where('student_id', $studentId) 
            ->get();
    
        return response()->json($submissions);
    }
    
    public function download($id)
    {
        $submission = Submission::findOrFail($id);
        return response()->download(storage_path('app/public/' . $submission->file_path));
    }

    public function destroy($id)
    {
        $submission = Submission::findOrFail($id);
        $submission->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $submission = Submission::withTrashed()->findOrFail($id);
        $submission->restore();
        return response()->json($submission);
    }

    public function forceDelete($id)
    {
        $submission = Submission::withTrashed()->findOrFail($id);
        $submission->forceDelete();
        return response()->json(null, 204);
    }

    public function getAllSubmissions($assignmentId)
    {
        if (!Assignment::find($assignmentId)) {
            return response()->json(['error' => 'Assignment not found.'], 404);
        }
    
        $submissions = Submission::where('assignment_id', $assignmentId)
                                 ->with(['student' => function($query) {
                                     $query->select('id', 'user_id')
                                           ->with(['user:id,first_name,middle_name,last_name']);
                                 }])
                                 ->get();
    
        return response()->json($submissions);
    }
    

}
