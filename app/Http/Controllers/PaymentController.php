<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Semester;
use App\Models\Fee;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|integer',
            'amount_paid' => 'required|numeric',
            'payment_date' => 'required|date',
            'currency' => 'required|in:USD,LBP',
            'description' => 'required|string'
        ]);
    
        $currentSemester = Semester::where('is_current', true)->first();
        if (!$currentSemester) {
            return response()->json(['error' => 'No current semester found'], 400);
        }
    
        $totalFeeUSD = Fee::where('student_id', $validatedData['student_id'])
            ->where('semester_id', $currentSemester->id)
            ->sum('amount_usd');
    
        $totalFeeLBP = Fee::where('student_id', $validatedData['student_id'])
            ->where('semester_id', $currentSemester->id)
            ->sum('amount_lbp');
    
        $totalPaidUSD = Payment::where('student_id', $validatedData['student_id'])
            ->where('semester_id', $currentSemester->id)
            ->where('currency', 'USD')
            ->sum('amount_paid');
    
        $totalPaidLBP = Payment::where('student_id', $validatedData['student_id'])
            ->where('semester_id', $currentSemester->id)
            ->where('currency', 'LBP')
            ->sum('amount_paid');
    
        if ($validatedData['currency'] == 'USD') {
            $totalPaidUSD += $validatedData['amount_paid'];
        } else {
            $totalPaidLBP += $validatedData['amount_paid'];
        }
    
        $remainingFeeUSD = $totalFeeUSD - $totalPaidUSD;
        $remainingFeeLBP = $totalFeeLBP - $totalPaidLBP;
    
        if (($validatedData['currency'] == 'USD' && $remainingFeeUSD < 0) ||
            ($validatedData['currency'] == 'LBP' && $remainingFeeLBP < 0)) {
            return response()->json(['error' => 'Payment amount exceeds remaining fees.'], 400);
        }
    
        $payment = Payment::create(array_merge($validatedData, ['semester_id' => $currentSemester->id]));
    
    
        return response()->json([
            'payment' => $payment,
            'total_fee_usd' => $remainingFeeUSD,
            'total_fee_lbp' => $remainingFeeLBP,
        ], 201);
    }
    
    
    public function restore($id)
    {
        $payment = Payment::withTrashed()->findOrFail($id);
        $payment->restore();
        return response()->json($payment);
    }

    public function forceDelete($id)
    {
        $payment = Payment::withTrashed()->findOrFail($id);
        $payment->forceDelete();
        return response()->json(null, 204);
    }
}
