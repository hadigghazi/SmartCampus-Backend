<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:50',
            'middle_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'mother_full_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string|max:20',
            'role' => 'required|in:Student,Admin,Instructor',
            'status' => 'required|in:Pending,Approved,Rejected',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:50',
            'second_nationality' => 'required|string|max:50',
            'country_of_birth' => 'required|string|max:50',
            'gender' => 'required|in:Male,Female',
            'marital_status' => 'required|in:Single,Married,Divorced,Widowed',
            'profile_picture' => 'required|string|max:255',
        ];
    }
}
