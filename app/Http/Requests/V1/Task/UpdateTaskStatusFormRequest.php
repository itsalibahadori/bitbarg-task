<?php

namespace App\Http\Requests\V1\Task;

use App\Enums\V1\TaskEnums;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskStatusFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'string',
                'in:' . implode(',', TaskEnums::allowedForUpdate()),
            ],
        ];
    }
}
