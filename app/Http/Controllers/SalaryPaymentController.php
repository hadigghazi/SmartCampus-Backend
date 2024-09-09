<?php

namespace App\Http\Controllers;

use App\Models\SalaryPayment;
use App\Http\Requests\StoreSalaryPaymentRequest;
use App\Http\Requests\UpdateSalaryPaymentRequest;
use Illuminate\Http\Request;

class SalaryPaymentController extends Controller
{
    public function index()
    {
        return SalaryPayment::all();
    }

    public function store(StoreSalaryPaymentRequest $request)
    {
        $salaryPayment = SalaryPayment::create($request->validated());
        return response()->json($salaryPayment, 201);
    }

    public function show(SalaryPayment $salaryPayment)
    {
        return $salaryPayment;
    }

    public function update(UpdateSalaryPaymentRequest $request, SalaryPayment $salaryPayment)
    {
        $salaryPayment->update($request->validated());
        return $salaryPayment;
    }

    public function destroy(SalaryPayment $salaryPayment)
    {
        $salaryPayment->delete();
        return response()->json(null, 204);
    }
}
