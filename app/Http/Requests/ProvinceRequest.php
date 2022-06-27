<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use Validator;

class ProvinceRequest extends FormRequest
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
				Rule::unique('provinces', 'name')->ignore($this->province ?: null, 'id')
				
			],
			'code' => [
				'required',
				'max:11',
				Rule::unique('provinces', 'code')->ignore($this->province ?: null, 'id')
			],
			'is_active' => [
				'required',
				'max:1',
			],
        ];
    }
}
