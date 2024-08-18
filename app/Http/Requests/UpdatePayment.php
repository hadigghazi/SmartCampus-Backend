<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePayment extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'sometimes|integer|exists:students,id',
            'description' => 'sometimes|string',
            'amount_usd' => 'sometimes|numeric|min:0',
            'amount_lbp' => 'sometimes|numeric|min:0',
            'exchange_rate' => 'sometimes|numeric|min:0',
            'payment_date' => 'sometimes|date',
        ];
    }
}
