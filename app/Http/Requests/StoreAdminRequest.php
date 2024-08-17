<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'admin_type' => 'required|in:Super Admin,Admin',
            'department_id' => 'required|exists:departments,id',
        ];
    }
}

class UpdateAdminRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'admin_type' => 'sometimes|in:Super Admin,Admin',
            'department_id' => 'sometimes|exists:departments,id',
        ];
    }
}
