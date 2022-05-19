<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    
    public function authorize()
    {
        // Will be managed in a policy
        return true;
    }

    public function rules()
    {
        // TODO
        return [
            'id' => ['required'],
            'title' => ['required'],
            'description' => ['nullable'],
            'deadline' => ['required'],
            'rating' => ['nullable'],
            'status' => ['nullable'],
            'job_category_id' => ['required'],
            'client_switch_uuid' => ['required', 'max:320'],
            'worker_switch_uuid' => ['nullable', 'max:320'],
            'validator_switch_uuid' => ['nullable', 'max:320'],
        ];
    }
}
