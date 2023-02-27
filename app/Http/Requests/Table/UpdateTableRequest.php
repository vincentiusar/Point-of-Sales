<?php

namespace App\Http\Requests\Table;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTableRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $this['table_id'] = $this->route('id');
        return [
            'table_id' => 'required|integer|exists:tables,id,deleted_at,NULL',
            'status' => 'required|string|in:open,ongoing,close,reserved',
            'session_id' => 'string',
        ];
    }
}
