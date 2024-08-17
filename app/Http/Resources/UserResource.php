<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'mother_full_name' => $this->mother_full_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'role' => $this->role,
            'status' => $this->status,
            'date_of_birth' => $this->date_of_birth,
            'nationality' => $this->nationality,
            'second_nationality' => $this->second_nationality,
            'country_of_birth' => $this->country_of_birth,
            'gender' => $this->gender,
            'marital_status' => $this->marital_status,
            'profile_picture' => $this->profile_picture,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
