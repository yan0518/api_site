<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyCodeRequest extends FormRequest
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
            'cell'        => 'bail|required|digits:11',
            'verify_code' => 'bail|required|string',
        ];
    }

    public function messages(){
        return [
            'cell.required'        => -1100023,
            'cell.digits'          => -1100006,
            'verify_code.required' => -1100024,
            'verify_code.string'   => -1100020,
        ];
    }
}
