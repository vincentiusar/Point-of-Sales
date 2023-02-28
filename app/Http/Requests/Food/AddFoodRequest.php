<?php

namespace App\Http\Requests\Food;

use Illuminate\Foundation\Http\FormRequest;

class AddFoodRequest extends FormRequest
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
        $this['restaurant_id'] = $this->route('restaurant_id');
        return [
            'restaurant_id' => 'required|integer|exists:restaurants,id,deleted_at,NULL',
            'name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|integer',
            'category' => 'required|in:dessert,main dishes,appetizer,beverage',
            // 'image' => 'string',
        ];
    }
}
