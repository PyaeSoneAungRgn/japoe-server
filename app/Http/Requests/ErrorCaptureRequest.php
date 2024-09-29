<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ErrorCaptureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_key' => ['required', 'exists:projects,key'],
            'exception' => ['required', 'string'],
            'message' => ['required', 'string'],
            'host' => ['nullable'],
            'method' => ['nullable', 'string'],
            'path' => ['nullable', 'string'],
            'headers' => ['nullable', 'array'],
            'query' => ['nullable', 'array'],
            'body' => ['nullable', 'array'],
            'controller' => ['nullable', 'string'],
            'command' => ['nullable', 'array'],
            'frames' => ['required', 'array'],
            'timezone' => ['required'],
            'frames.*.snippet' => ['required', 'array'],
            'frames.*.line_number' => ['required', 'integer'],
            'frames.*.file' => ['required', 'string'],
            'frames.*.method' => ['nullable', 'string'],
        ];
    }
}
