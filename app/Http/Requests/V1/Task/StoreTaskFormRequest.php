<?php

namespace App\Http\Requests\V1\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class StoreTaskFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'due_date' => [
                'required',
                'string',
                'date',
                'after:' . Carbon::now(),
            ],
            'description' => [
                'required',
                'string',
                'max:65535'
            ],
            'assigned_users' => [
                'nullable',
                'array'
            ],
            'assigned_users.*' => [
                'integer',
                'distinct',
                'exists:users,id'
            ]
        ];
    }
}
