<?php

namespace App\Http\Requests\Employee\EmployeeDepartment;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentUpdate extends FormRequest
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
            'department' => 'required|max:55|unique:employee_departments',
        ];
    }
}