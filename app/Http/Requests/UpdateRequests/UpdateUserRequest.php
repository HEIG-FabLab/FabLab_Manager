<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'switch_uuid' => ['required'],
            'email' => ['required', 'email'],
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'password' => ['nullable'],
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'string', 'exists:roles,name'],
        ];
    }
}
