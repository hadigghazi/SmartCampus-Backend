<?php

namespace App\Http\Controllers;

use App\Models\FinancialAidScholarship;
use Illuminate\Http\Request;

class FinancialAidScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = FinancialAidScholarship::all();
        return response()->json($scholarships);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric',
            'type' => 'required|string',
            'effective_date' => 'required|date',
        ]);

        $scholarship = FinancialAidScholarship::create($request->all());
        return response()->json($scholarship, 201);
    }

    public function show(FinancialAidScholarship $financialAidScholarship)
    {
        return response()->json($financialAidScholarship);
    }

    public function update(Request $request, FinancialAidScholarship $financialAidScholarship)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric',
            'type' => 'required|string',
            'effective_date' => 'required|date',
        ]);

        $financialAidScholarship->update($request->all());
        return response()->json($financialAidScholarship);
    }

    public function destroy(FinancialAidScholarship $financialAidScholarship)
    {
        $financialAidScholarship->delete();
        return response()->json(null, 204);
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
}
