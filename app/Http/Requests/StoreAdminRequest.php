<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }
    
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'admin_type' => 'required|in:Super Admin,Admin',
            'department_id' => 'required|exists:departments,id',
            'salary' => 'required|numeric'
        ];
    }
}