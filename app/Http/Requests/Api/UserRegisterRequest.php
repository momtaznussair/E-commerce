<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:11|numeric|unique:users,phone',
            'city_id' => 'required|exists:cities,id',
            'country' => 'required|exists:countries,id',
            'avatar' =>  'nullable|image|max:1024', //1MB Max
            'password' => ['required', 'confirmed', Password::defaults()],
            'dob' => 'required|date_format:Y-m-d|before:today',
            'gender' => 'required|boolean',
        ];
    }
}
