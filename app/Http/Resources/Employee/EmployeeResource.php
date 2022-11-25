<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'employee_id' => $this->employee_id,
            'designation_id' => $this->designation_id,
            'department_id' => $this->department_id,
            'gender' => $this->gender,
            'about_me' => $this->about_me,
            'contact_number' => $this->contact_number,
            'emergency_contact_number' => $this->emergency_contact_number,
            'Address' => $this->address,
            'date_of_birth' => $this->date_of_birth,
            'profile_picture' => $this->profile_picture,
            'role_id' => $this->role_id,
        ];
    }
}
