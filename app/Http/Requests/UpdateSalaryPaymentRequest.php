<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalaryPaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'amount' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'recipient_id' => 'nullable|exists:users,id',
            'recipient_type' => 'nullable|in:Instructor,Admin',
        ];
    }
}
