<?php

namespace App\Http\Controllers;

use App\Models\PaymentLbp;
use Illuminate\Http\Request;

class PaymentLbpController extends Controller
{
    public function index()
    {
        $paymentsLbp = PaymentLbp::all();
        return response()->json($paymentsLbp);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'description' => 'required|string',
            'amount_paid' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);

        $paymentLbp = PaymentLbp::create($request->all());
        return response()->json($paymentLbp, 201);
    }

    public function show(PaymentLbp $paymentLbp)
    {
        return response()->json($paymentLbp);
    }

    public function update(Request $request, PaymentLbp $paymentLbp)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'description' => 'required|string',
            'amount_paid' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);

        $paymentLbp->update($request->all());
        return response()->json($paymentLbp);
    }

    public function destroy(PaymentLbp $paymentLbp)
    {
        $paymentLbp->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $paymentLbp = PaymentLbp::withTrashed()->findOrFail($id);
        $paymentLbp->restore();
        return response()->json($paymentLbp);
    }

    public function forceDelete($id)
    {
        $paymentLbp = PaymentLbp::withTrashed()->findOrFail($id);
        $paymentLbp->forceDelete();
        return response()->json(null, 204);
    }
}
