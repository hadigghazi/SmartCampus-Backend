<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFinancialAidScholarship extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'required|integer|exists:students,id',
            'type' => 'required|string|max:100',
            'amount_usd' => 'required|numeric|min:0',
            'amount_lbp' => 'required|numeric|min:0',
            'description' => 'required|string',
        ];
    }
}
