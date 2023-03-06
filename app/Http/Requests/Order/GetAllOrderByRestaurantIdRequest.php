<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class GetAllOrderByRestaurantIdRequest extends FormRequest
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
        ];
    }
}
