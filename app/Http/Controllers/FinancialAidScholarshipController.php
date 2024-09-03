<?php

namespace App\Http\Controllers;

use App\Models\FinancialAidScholarship;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Http\Request;

class FinancialAidScholarshipController extends Controller
{
    public function getFinancialAidsScholarshipsByStudent($studentId)
    {
        $student = Student::find($studentId);
    
        if (!$student) {
            return response()->json(['message' => 'Student not found.'], 404);
        }
    
        $currentSemester = Semester::where('is_current', true)->first();
    
        if (!$currentSemester) {
            return response()->json(['message' => 'Current semester not found.'], 404);
        }
    
        $financialAidsScholarships = FinancialAidScholarship::where('student_id', $studentId)
            ->where('semester_id', $currentSemester->id)
            ->whereNull('deleted_at')
            ->get();
    
        if ($financialAidsScholarships->isEmpty()) {
            return response()->json([
                'message' => 'No financial aids or scholarships found for this student in the current semester.',
                'total_percentage' => 0
            ], 200);
        }
    
        $totalPercentage = $financialAidsScholarships->sum('percentage');
    
        return response()->json([
            'financial_aids_scholarships' => $financialAidsScholarships,
            'total_percentage' => $totalPercentage
        ], 200);
    }
    
    
    public function createFinancialAidScholarship(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|string',
            'percentage' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|string',
        ]);
    
        $currentSemester = Semester::where('is_current', true)->first();
    
        if (!$currentSemester) {
            return response()->json(['message' => 'Current semester not found.'], 404);
        }
    
        $totalExistingPercentage = FinancialAidScholarship::where('student_id', $validatedData['student_id'])
            ->where('semester_id', $currentSemester->id)
            ->whereNull('deleted_at')
            ->sum('percentage');
    
        $newTotalPercentage = $totalExistingPercentage + $validatedData['percentage'];
    
        if ($newTotalPercentage > 100) {
            return response()->json([
                'message' => 'The total percentage of financial aids and scholarships for this student in the current semester exceeds 100%.',
                'current_total_percentage' => $totalExistingPercentage,
                'remaining_percentage' => 100 - $totalExistingPercentage
            ], 400);
        }
    
        $financialAidScholarship = new FinancialAidScholarship();
        $financialAidScholarship->student_id = $validatedData['student_id'];
        $financialAidScholarship->semester_id = $currentSemester->id;
        $financialAidScholarship->type = $validatedData['type'];
        $financialAidScholarship->percentage = $validatedData['percentage'];
        $financialAidScholarship->description = $validatedData['description'] ?? '';
        $financialAidScholarship->created_at = now();
        $financialAidScholarship->updated_at = now();
    
        $financialAidScholarship->save();
    
        return response()->json($financialAidScholarship, 201);
    }
    

    public function restore($id)
    {
        $financialAidScholarship = FinancialAidScholarship::withTrashed()->findOrFail($id);
        $financialAidScholarship->restore();
        return response()->json($financialAidScholarship);
    }

    public function forceDelete($id)
    {
        $financialAidScholarship = FinancialAidScholarship::withTrashed()->findOrFail($id);
        $financialAidScholarship->forceDelete();
        return response()->json(null, 204);
    }

    public function deleteFinancialAidScholarship($id)
{
    $financialAidScholarship = FinancialAidScholarship::find($id);

    if (!$financialAidScholarship) {
        return response()->json(['message' => 'Financial aid or scholarship not found.'], 404);
    }

    $financialAidScholarship->delete();

    return response()->json([
        'message' => 'Financial aid or scholarship deleted successfully.'
    ], 200);
}

}
