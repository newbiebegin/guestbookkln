<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use Validator;

class CityRequest extends FormRequest
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
            //
			'name' => [
				'required',
				'max:100',
				Rule::unique('cities', 'name')->ignore($this->city ?: null, 'id')
				
			],
			'code' => [
				'required',
				'max:11',
				Rule::unique('cities', 'code')->ignore($this->city ?: null, 'id')
			],
			'is_active' => [
				'required',
				'max:1',
			],
        ];
    }
}
