<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalaryPaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'recipient_id' => 'required|exists:users,id',
            'recipient_type' => 'required|in:Instructor,Admin',
        ];
    }
}
