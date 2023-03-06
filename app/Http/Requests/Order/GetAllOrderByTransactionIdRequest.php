<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class GetAllOrderByTransactionIdRequest extends FormRequest
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
        $this['transaction_id'] = $this->route('transaction_id');
        return [
            'transaction_id' => 'required|integer|exists:transactions,id,deleted_at,NULL'
        ];
    }
}
