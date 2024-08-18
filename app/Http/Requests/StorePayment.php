<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePayment extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'required|integer|exists:students,id',
            'description' => 'required|string',
            'amount_usd' => 'required|numeric|min:0',
            'amount_lbp' => 'required|numeric|min:0',
            'exchange_rate' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ];
    }
}
