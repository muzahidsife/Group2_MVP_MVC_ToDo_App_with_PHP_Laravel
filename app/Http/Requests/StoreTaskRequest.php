<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'due_date'    => 'nullable|date|after_or_equal:today',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'          => 'Please enter a task title.',
            'due_date.after_or_equal' => 'Due date cannot be in the past.',
        ];
    }
}
