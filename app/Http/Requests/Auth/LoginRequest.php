<?php

namespace App\Http\Requests\Auth;

use App\Rules\EmailOrPhone;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'emailOrPhone' => ['required', new EmailOrPhone()],
            'password' => 'required'
        ];
    }
}
