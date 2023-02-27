<?php

namespace App\Http\Requests\Table;

use Illuminate\Foundation\Http\FormRequest;

class DeleteTableRequest extends FormRequest
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
        $this['id'] = $this->route('id');
        return [
            'id' => 'exists:tables,id,deleted_at,NULL'
        ];
    }
}
