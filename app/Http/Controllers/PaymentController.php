<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Semester;
use App\Models\FinancialAidScholarship;
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

    public function getPaymentsByStudent($student_id)
    {
        $currentSemester = Semester::where('is_current', true)->first();
        if (!$currentSemester) {
            return response()->json(['error' => 'No current semester found'], 400);
        }
    
        $payments = Payment::where('student_id', $student_id)
            ->where('semester_id', $currentSemester->id)
            ->get();
    
        return response()->json($payments);
    }
    

    public function checkFeesPaid()
    {
        $userId = auth()->id();

        $studentId = \App\Models\Student::where('user_id', $userId)->value('id');
        
        $previousSemester = Semester::where('is_current', false)
            ->orderBy('start_date', 'desc') 
            ->first();
        
        $currentSemester = Semester::where('is_current', true)->first();
    
        if (!$previousSemester && !$currentSemester) {
            return response()->json(['error' => 'No semesters found'], 400);
        }
    
        $totalFeesUSD = 0;
        $totalFeesLBP = 0;
        $totalPaymentsUSD = 0;
        $totalPaymentsLBP = 0;
    
        $accumulateSemesterData = function ($semesterId) use (&$totalFeesUSD, &$totalFeesLBP, &$totalPaymentsUSD, &$totalPaymentsLBP, $studentId) {
            $feesUSD = Fee::where('student_id', $studentId)
                ->where('semester_id', $semesterId)
                ->sum('amount_usd');
    
            $feesLBP = Fee::where('student_id', $studentId)
                ->where('semester_id', $semesterId)
                ->sum('amount_lbp');
    
            $paymentsUSD = Payment::where('student_id', $studentId)
                ->where('semester_id', $semesterId)
                ->where('currency', 'USD')
                ->sum('amount_paid');
    
            $paymentsLBP = Payment::where('student_id', $studentId)
                ->where('semester_id', $semesterId)
                ->where('currency', 'LBP')
                ->sum('amount_paid');
    
            $financialAids = FinancialAidScholarship::where('student_id', $studentId)
                ->where('semester_id', $semesterId)
                ->get();
    
            $totalDiscountPercentage = $financialAids->sum('percentage') / 100;
    
            $feesUSD -= $feesUSD * $totalDiscountPercentage;
            $feesLBP -= $feesLBP * $totalDiscountPercentage;
    
            $totalFeesUSD += $feesUSD;
            $totalFeesLBP += $feesLBP;
            $totalPaymentsUSD += $paymentsUSD;
            $totalPaymentsLBP += $paymentsLBP;
        };
    
        if ($previousSemester) {
            $accumulateSemesterData($previousSemester->id);
        }
    
        if ($currentSemester) {
            $accumulateSemesterData($currentSemester->id);
        }
    
        if ($totalFeesUSD == 0 && $totalFeesLBP == 0) {
            return response()->json([
                'fees_paid' => true,
                'remaining_fees_usd' => 0,
                'remaining_fees_lbp' => 0,
            ]);
        }
    
        $remainingFeesUSD = $totalFeesUSD - $totalPaymentsUSD;
        $remainingFeesLBP = $totalFeesLBP - $totalPaymentsLBP;
    
        $feesPaid = $remainingFeesUSD <= 0 && $remainingFeesLBP <= 0;
    
        return response()->json([
            'fees_paid' => $feesPaid,
            'remaining_fees_usd' => max($remainingFeesUSD, 0),
            'remaining_fees_lbp' => max($remainingFeesLBP, 0),
        ]);
    }
    
}
