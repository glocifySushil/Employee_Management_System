<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;


class EmployeeStoreRequest extends FormRequest
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
             'name'     => 'required|max:55',
             'email'    => 'email|required|unique:users',
             'password' => 'required|confirmed',
             'role_id'  => 'required',
        ];

    }

    public function message(){

        return [
            'email.required' => 'Email Address is required!',
            'name.required' => 'Name is required!',
            'password.required' => 'Password is required!',
            'password.confirmation' => 'Confirm Password id Required',
            'role_id.required' => 'Role is required'
        ];
    }


}
