<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFinancialAidScholarship extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'sometimes|integer|exists:students,id',
            'type' => 'sometimes|string|max:100',
            'amount_usd' => 'sometimes|numeric|min:0',
            'amount_lbp' => 'sometimes|numeric|min:0',
            'description' => 'sometimes|string',
        ];
    }
}
