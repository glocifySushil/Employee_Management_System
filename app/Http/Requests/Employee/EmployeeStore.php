<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'name' => 'required|max:55',
            'email'    => 'email|required|unique:users',
            'password' => 'required|confirmed',
            'role_id'  => 'required',
            'employee_id' => 'required|unique:users',
            'designation_id' => 'required',
            'department_id' => 'required',
            'employee_status_id' => 'required',
            'gender' => 'required',
            'about_me' => 'required',
            'contact_number' => 'required|numeric|digits:10|unique:users',
            'emergency_contact_number' => 'required|numeric|digits:10|unique:users',
            'address' => 'required',
            'date_of_birth' => 'date_format:Y-m-d|before:today|required',
            //'profile_picture' => 'image|mimes:jpg,jpeg,png,PNG,gif',
            
        ];
    }
}
