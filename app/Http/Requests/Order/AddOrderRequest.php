<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class AddOrderRequest extends FormRequest
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
        $this['transaction_id'] = $this->route('transaction_id');

        return [
            'restaurant_id' => 'required|integer|exists:restaurants,id,deleted_at,NULL',
            'transaction_id' => 'required|integer|exists:transactions,id,deleted_at,NULL',
            'orders' => 'required|array|min:0',
            'orders.*.food_id' => 'required|integer|exists:food,id,deleted_at,NULL',
            'orders.*.quantity' => 'required|integer|min:1',
            'orders.*.note' => 'nullable|string|min:1',
        ];
    }
}
