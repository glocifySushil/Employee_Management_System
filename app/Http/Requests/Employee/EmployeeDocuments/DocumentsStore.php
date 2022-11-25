<?php

namespace App\Http\Requests\Employee\EmployeeDocuments;

use Illuminate\Foundation\Http\FormRequest;

class DocumentsStore extends FormRequest
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
            'attachment' => 'required|file|mimes:xlsx,xls,csv,jpg,jpeg,png,bmp,doc,docx,pdf,tif,tiff'
        ];
    }
}
