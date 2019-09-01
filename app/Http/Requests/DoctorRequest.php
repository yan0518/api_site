<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
            'name'       => 'bail|required|string',
            'hospital'   => 'bail|required|string',
            'department' => 'bail|required|integer',
            'position'   => 'bail|required|integer',
            'cell'       => 'bail|required|digits:11',
            'saler'      => 'bail|sometimes|string',
            'sale_cell'  => 'bail|sometimes|digits:11'
        ];
    }

    public function messages(){
        return [
            'name.required'       => -1100009,
            'name.string'         => -1100010,
            'hospital.required'   => -1100011,
            'hospital.integer'    => -1100012,
            'department.required' => -1100013,
            'department.integer'  => -1100014,
            'position.required'   => -1100015,
            'position.integer'    => -1100016,
            'cell.required'       => -1100017,
            'cell.digits'        => -1100018,
            'saler.string'        => -1100019,
            'sale_cell.digits'   => -1100020,
        ];
    }
}
