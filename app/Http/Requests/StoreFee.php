<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFee extends FormRequest
{
    public function rules()
    {
        return [
            'description' => 'required|string',
            'amount_usd' => 'required|numeric|min:0',
            'amount_lbp' => 'required|numeric|min:0',
            'exchange_rate' => 'required|numeric|min:0',
            'faculty_id' => 'required|integer|exists:faculties,id',
            'credit_price_usd' => 'required|numeric|min:0',
            'credit_price_lbp' => 'required|numeric|min:0',
        ];
    }
}
