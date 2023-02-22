<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataTableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'regex:/^[a-zA-Z0-9_\s.,\/]+$/i'],
            'sort' => ['nullable', 'regex:/^[a-zA-Z0-9_]+$/i'],
            'order' => ['nullable', 'in:desc,asc'],
            'page' => ['numeric'],
            'per_page' => ['numeric'],
        ];
    }
}
