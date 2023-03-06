<?php

namespace App\Http\Requests\Restaurant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantRequest extends FormRequest
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
        $this['restaurant_id'] = auth()->user()->restaurant_id;
        return [
            'restaurant_id' => 'integer|required|exists:restaurants,id,deleted_at,NULL',
            'name' => 'string',
            'description' => 'string',
            'address' => 'string'
        ];
    }
}
