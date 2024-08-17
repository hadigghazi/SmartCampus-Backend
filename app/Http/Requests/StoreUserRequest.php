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
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'mother_full_name' => 'nullable|string|max:50',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|in:Student,Admin,Instructor',
            'status' => 'required|in:Pending,Approved,Rejected',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:50',
            'second_nationality' => 'nullable|string|max:50',
            'country_of_birth' => 'nullable|string|max:50',
            'gender' => 'nullable|in:Male,Female',
            'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            'profile_picture' => 'nullable|string|max:255'
        ];
    }
}
