<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'sometimes|string|max:50',
            'middle_name' => 'sometimes|string|max:50',
            'last_name' => 'sometimes|string|max:50',
            'mother_full_name' => 'sometimes|string|max:50',
            'email' => 'sometimes|email|max:100|unique:users,email,' . $this->route('user'),
            'password' => 'sometimes|string|min:8',
            'phone_number' => 'sometimes|string|max:20',
            'role' => 'sometimes|in:Student,Admin,Instructor',
            'status' => 'sometimes|in:Pending,Approved,Rejected',
            'date_of_birth' => 'sometimes|date',
            'nationality' => 'sometimes|string|max:50',
            'second_nationality' => 'sometimes|string|max:50',
            'country_of_birth' => 'sometimes|string|max:50',
            'gender' => 'sometimes|in:Male,Female',
            'marital_status' => 'sometimes|in:Single,Married,Divorced,Widowed',
            'profile_picture' => 'sometimes|string|max:255',
        ];
    }
}
