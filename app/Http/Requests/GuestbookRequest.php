<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class GuestbookRequest extends FormRequest
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
			'first_name' => [
				'required',
				'max:100',
			],
			'last_name' => [
				'max:100',
			],
			'organization' => [
				'max:100',
			],
			'address' => [
				'required',
			],
			'phone' => [
				'required',
				'max:15',
			],
			'message' => [
				'required',
			],
			'province_id' => [
				'required',
				'exists:provinces,id'
			],
			'city_id' => [
				'required',
				'exists:cities,id'
			],
			'is_active' => [
				 Auth::check() ? 'required' : '',
				'max:1',
			],
        ];
    }
}
