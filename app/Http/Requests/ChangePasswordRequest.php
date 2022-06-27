<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use Validator;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required|min:3|current_password',
            'new_password' => 'required|min:3',
            'new_password_confirmation' => 'required|same:new_password'
        ];
    }
	
	public function attributes()
	{
		return [
				'current_password' => 'current password',
			];
	}	
	
	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'current_password.current_password' => 'The current password is incorrect.',
		];
	}
}
