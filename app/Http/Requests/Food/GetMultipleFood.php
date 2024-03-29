<?php

namespace App\Http\Requests\Food;

use Illuminate\Foundation\Http\FormRequest;

class GetMultipleFood extends FormRequest
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
        return [
            'foods' => 'required|array|min:1',
            'foods.*.food_id' => 'required|integer|exists:food,id,deleted_at,NULL'
        ];
    }
}
