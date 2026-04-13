<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'category_id' => 'nullable|exists:categories,id',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'nullable|date',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ];
    }
}
