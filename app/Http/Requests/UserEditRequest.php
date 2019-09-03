<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
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
            'name'     => 'bail|nullable|string',
            'login_id' => 'bail|nullable|string',
            'password' => 'bail|nullable|string|min:6',
            'cell'     => 'bail|nullable|digits:11',
        ];
    }

    public function messages(){
        return [
            'name.string'       => -1100010,
            'login_id.string'   => -1100030,
            'password.string'   => -1100008,
            'password.min'      => -1100008,
            'cell.digits'       => -1100018
        ];
    }
}
