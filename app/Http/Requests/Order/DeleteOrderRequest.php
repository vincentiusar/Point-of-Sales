<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class DeleteOrderRequest extends FormRequest
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
        $this['order_id'] = $this->route('id');
        return [
            'order_id' => 'required|integer|exists:orders,id,deleted_at,NULL'
        ];
    }
}
