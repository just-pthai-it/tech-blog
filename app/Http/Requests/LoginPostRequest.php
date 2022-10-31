<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginPostRequest extends FormRequest
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
        return match ($this->route('option'))
        {
            'third-party' => [
                'third_party_id' => ['required', 'string']
            ],

            default => [
                'email'    => ['required', 'string', 'email:rfc,dns'],
                'password' => ['required', 'string']
            ],
        };

    }
}
