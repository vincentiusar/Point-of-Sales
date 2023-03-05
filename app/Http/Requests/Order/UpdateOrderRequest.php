<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'orders' => 'required|array|min:0',
            'orders.*.order_id' => 'required|integer|exists:orders,id,deleted_at,NULL',
            'orders.*.quantity' => 'required|integer|min:1',
        ];
    }
}
