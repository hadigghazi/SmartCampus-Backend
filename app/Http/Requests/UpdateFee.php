<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFee extends FormRequest
{
    public function rules()
    {
        return [
            'description' => 'sometimes|string',
            'amount_usd' => 'sometimes|numeric|min:0',
            'amount_lbp' => 'sometimes|numeric|min:0',
            'exchange_rate' => 'sometimes|numeric|min:0',
            'faculty_id' => 'sometimes|integer|exists:faculties,id',
            'credit_price_usd' => 'sometimes|numeric|min:0',
            'credit_price_lbp' => 'sometimes|numeric|min:0',
        ];
    }
}
