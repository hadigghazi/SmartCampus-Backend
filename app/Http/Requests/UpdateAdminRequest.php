<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }
    
    public function rules()
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'admin_type' => 'sometimes|in:Super Admin,Admin',
            'department_id' => 'sometimes|exists:departments,id',
        ];
    }
}
