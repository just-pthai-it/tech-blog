<?php

namespace App\Http\Requests\Auth;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Http\FormRequest;
use const App\Helpers\ROLES;

class LogoutPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize () : bool
    {
        return in_array($this->user()->role, Arr::only(ROLES, ['normal_user', 'premium_user']));
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules () : array
    {
        return [];
    }
}
