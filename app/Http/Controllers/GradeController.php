<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGrade;
use App\Http\Requests\UpdateGrade;

class GradeController extends Controller
{
    public function index()
    {
        $items = Grade::get();
        return response()->json($items);
    }

    public function store(StoreGrade $request)
    {
        $validatedData = $request->validated();
        $grade = new Grade();
        $grade->grade = $validatedData['grade'];
        $grade->letter_grade = $this->convertToLetterGrade($validatedData['grade']);
        $grade->gpa = $this->calculateGPA($validatedData['grade']);
        $grade->registration_id = $this->getRegistrationId($validatedData['student_id'], $validatedData['course_instructor_id']);
        $grade->save();
    
        return response()->json($grade, 201);
    }
    

    public function show($id)
    {
        $item = Grade::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateGrade $request, $id)
    {
        $item = Grade::withTrashed()->findOrFail($id);
        $validatedData = $request->validated();
        $item->grade = $validatedData['grade'];
        $item->letter_grade = $this->convertToLetterGrade($validatedData['grade']);
        $item->gpa = $this->calculateGPA($validatedData['grade']);
        $item->save(); 
    
        return response()->json($item);
    }
    

    public function destroy($id)
    {
        $item = Grade::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = Grade::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Grade::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }

    public function getGradesByInstructor($course_instructor_id) {
        $validator = \Validator::make([
            'course_instructor_id' => $course_instructor_id,
        ], [
            'course_instructor_id' => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }
    
        $registrations = Registration::where('course_instructor_id', $course_instructor_id)
            ->get();
    
        if ($registrations->isEmpty()) {
            return response()->json(['error' => 'No registrations found'], 404);
        }
    
        $gradesData = [];
    
        foreach ($registrations as $registration) {
            $grade = Grade::where('registration_id', $registration->id)->first();
    
            if ($grade) {
                $studentGradeData = [
                    'id' => $grade->id,
                    'student_id' => $registration->student_id,
                    'course_instructor_id' => $registration->course_instructor_id,
                    'status' => $registration->status,
                    'grade' => $grade->grade,
                    'letter_grade' => $grade->letter_grade,
                    'gpa' => $grade->gpa,
                    'created_at' => $grade->created_at,
                    'updated_at' => $grade->updated_at,
                ];
    
                $gradesData[] = $studentGradeData;
            }
        }
    
        if (empty($gradesData)) {
            return response()->json(['error' => 'No grades found'], 404);
        }
    
        return response()->json($gradesData, 200);
    }
    

    public function addGrade(Request $request) {
        $request->validate([
            'student_id' => 'required|integer',
            'course_instructor_id' => 'required|integer',
            'grade' => 'required|numeric|min:0|max:100',
        ]);
    
        $registration = Registration::where('student_id', $request->student_id)
            ->where('course_instructor_id', $request->course_instructor_id)
            ->first();
    
        if (!$registration) {
            return response()->json(['error' => 'Registration not found'], 404);
        }
    
        $grade = new Grade();
        $grade->grade = $request->grade;
        $grade->letter_grade = $this->convertToLetterGrade($request->grade);
        $grade->registration_id = $registration->id;
        $grade->gpa = $this->calculateGPA($request->grade);
        $grade->save();
    
        $responseData = $grade->toArray();
        $responseData['status'] = $registration->status;
    
        return response()->json($responseData, 201);
    }
    
    
    private function convertToLetterGrade($grade) {
        if ($grade >= 90) {
            return 'A';
        } elseif ($grade >= 80) {
            return 'B';
        } elseif ($grade >= 70) {
            return 'C';
        } elseif ($grade >= 60) {
            return 'D';
        } else {
            return 'F';
        }
    }
    
    private function calculateGPA($grade) {
        if ($grade >= 90) {
            return 4.0;
        } elseif ($grade >= 80) {
            return 3.0 + (($grade - 80) * 0.1);
        } elseif ($grade >= 70) {
            return 2.0 + (($grade - 70) * 0.1);
        } elseif ($grade >= 60) {
            return 1.0 + (($grade - 60) * 0.1);
        } else {
            return 0.0;
        }
    }
    
}
