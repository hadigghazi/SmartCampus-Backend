<?php

namespace App\Http\Controllers;

use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function index()
    {
        $paymentSettings = PaymentSetting::all();
        return response()->json($paymentSettings);
    }

    public function store(Request $request)
    {
        $request->validate([
            'exchange_rate' => 'required|numeric',
            'lbp_percentage' => 'required|numeric',
            'registration_fee_usd' => 'required|numeric',
            'effective_date' => 'required|date',
        ]);

        $paymentSetting = PaymentSetting::create($request->all());
        return response()->json($paymentSetting, 201);
    }

    public function show(PaymentSetting $paymentSetting)
    {
        return response()->json($paymentSetting);
    }

    public function update(Request $request, PaymentSetting $paymentSetting)
    {
        $request->validate([
            'exchange_rate' => 'required|numeric',
            'lbp_percentage' => 'required|numeric',
            'registration_fee_usd' => 'required|numeric',
            'effective_date' => 'required|date',
        ]);

        $paymentSetting->update($request->all());
        return response()->json($paymentSetting);
    }

    public function destroy(PaymentSetting $paymentSetting)
    {
        $paymentSetting->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $paymentSetting = PaymentSetting::withTrashed()->findOrFail($id);
        $paymentSetting->restore();
        return response()->json($paymentSetting);
    }

    public function forceDelete($id)
    {
        $paymentSetting = PaymentSetting::withTrashed()->findOrFail($id);
        $paymentSetting->forceDelete();
        return response()->json(null, 204);
    }
}
