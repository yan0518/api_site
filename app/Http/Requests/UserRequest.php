<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'     => 'bail|required|string',
            'login_id' => 'bail|required|string',
            'password' => 'bail|required|string|min:6',
            'cell'     => 'bail|required|digits:11'
        ];
    }

    public function messages(){
        return [
            'name.required'     => -1100009,
            'name.string'       => -1100010,
            'login_id.required' => -1100029,
            'login_id.string'   => -1100030,
            'password.required' => -1100028,
            'password.string'   => -1100008,
            'password.min'      => -1100008,
            'cell.required'     => -1100017,
            'cell.digits'       => -1100018
        ];
    }
}
