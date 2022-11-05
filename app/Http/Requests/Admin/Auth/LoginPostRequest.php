<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Http\FormRequest;
use const App\Helpers\ROLES;

class LoginPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize () : bool
    {
        return true;
        //        return in_array($this->user()->role, Arr::only(ROLES, ['admin', 'mod']));
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules () : array
    {
        return [
            'email'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }
}
