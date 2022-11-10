<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Http\FormRequest;
use const App\Helpers\ROLES;

class UpdateUserPatchRequest extends FormRequest
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
        return [
            'nickname'      => ['sometimes', 'required', 'string', 'unique:users'],
            'name'          => ['sometimes', 'required', 'string'],
            'birth'         => ['sometimes', 'present', 'string'],
            'gender'        => ['sometimes', 'present', 'boolean'],
            'bio'           => ['sometimes', 'present', 'string'],
            'work'          => ['sometimes', 'present', 'string'],
            'education'     => ['sometimes', 'present', 'string'],
            'coding_skills' => ['sometimes', 'present', 'string'],
        ];
    }
}
