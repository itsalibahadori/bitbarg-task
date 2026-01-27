<?php

namespace App\Http\Requests\V1\Task;

use App\Enums\V1\TaskEnums;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskFormRequest extends FormRequest
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
            'status' => [
                'required',
                'string',
                'in:' . implode(',', TaskEnums::allowedForUpdate()),
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
