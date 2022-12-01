<?php

namespace App\Http\Requests\Employee\EmployeeAttendence;

use Illuminate\Foundation\Http\FormRequest;

class AttendenceUpdate extends FormRequest
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
            'punch_in'     => 'required|date_format:Y-m-d',
            'punch_out'     => 'required|date_format:Y-m-d',
            'punch_in_ip'    => 'required',
            'punch_in_out' => 'required'
             
           
       ];
    }
}
