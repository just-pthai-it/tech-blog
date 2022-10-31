<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize () : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules () : array
    {
        $rules = [
            'name'     => ['required', 'string'],
            'nickname' => ['required', 'string'],
            'email'    => ['required', 'string', 'email:rfc,dns'],
        ];

        if ($this->route('option') == 'third-party')
        {
            return array_merge($rules, [
                'github'   => ['required_without_all:facebook,google', 'string'],
                'facebook' => ['required_without_all:github,google', 'string'],
                'google'   => ['required_without_all:facebook,github', 'string'],
            ]);
        }

        return array_merge($rules, ['password' => ['required', 'string'],]);
    }
}
