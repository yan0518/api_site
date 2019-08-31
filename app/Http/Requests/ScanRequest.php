<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScanRequest extends FormRequest
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
            'house_id' => 'bail|required|integer',
            'type'     => 'bail|required|integer',
            'code'     => 'bail|required|string',
            'crop_id'  => 'bail|required|integer',
        ];

    }

    public function messages(){
        return [
            'house_id.required' => -1100016,
            'house_id.integer'  => -1100009,
            'code.required'     => -1100017,
            'code.string'       => -1100018,
            'type.required'     => -1100011,
            'type.integer'      => -1100010,
            'crop_id.required'  => -1100028,
            'crop_id.integer'   => -2100013,
        ];
    }
}
