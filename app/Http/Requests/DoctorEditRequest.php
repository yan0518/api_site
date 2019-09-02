<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorEditRequest extends FormRequest
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
            'id'         => 'bail|required|integer',
            'name'       => 'bail|nullable|string',
            'hospital'   => 'bail|nullable|string',
            'department' => 'bail|nullable|integer',
            'position'   => 'bail|nullable|integer',
            'cell'       => 'bail|nullable|digits:11',
            'saler'      => 'bail|nullable|string',
            'sale_cell'  => 'bail|nullable|digits:11'
        ];
    }

    public function messages(){
        return [
            'id.required'        => -1100021,
            'id.integer'         => -1100022,
            'name.string'        => -1100010,
            'hospital.integer'   => -1100012,
            'department.integer' => -1100014,
            'position.integer'   => -1100016,
            'cell.digits'       => -1100018,
            'saler.string'       => -1100019,
            'sale_cell.digits'  => -1100020,
        ];
    }
}
