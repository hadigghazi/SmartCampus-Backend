<?php

namespace App\Http\Controllers;

use App\Models\PaymentUsd;
use Illuminate\Http\Request;

class PaymentUsdController extends Controller
{
    public function index()
    {
        $paymentsUsd = PaymentUsd::all();
        return response()->json($paymentsUsd);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'description' => 'required|string',
            'amount_paid' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);

        $paymentUsd = PaymentUsd::create($request->all());
        return response()->json($paymentUsd, 201);
    }

    public function show(PaymentUsd $paymentUsd)
    {
        return response()->json($paymentUsd);
    }

    public function update(Request $request, PaymentUsd $paymentUsd)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'description' => 'required|string',
            'amount_paid' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);

        $paymentUsd->update($request->all());
        return response()->json($paymentUsd);
    }

    public function destroy(PaymentUsd $paymentUsd)
    {
        $paymentUsd->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $paymentUsd = PaymentUsd::withTrashed()->findOrFail($id);
        $paymentUsd->restore();
        return response()->json($paymentUsd);
    }

    public function forceDelete($id)
    {
        $paymentUsd = PaymentUsd::withTrashed()->findOrFail($id);
        $paymentUsd->forceDelete();
        return response()->json(null, 204);
    }
}
