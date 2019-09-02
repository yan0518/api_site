<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientCreateRequest extends FormRequest
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
            'cell' => 'bail|required|digits:11',
            'type' => 'bail|required|integer',
        ];
    }

    public function messages(){
        return [
            'cell.required' => -1100017,
            'cell.digits'   => -1100018,
            'type.required' => -1100024,
            'type.integer'  => -1100025,
        ];
    }
}
