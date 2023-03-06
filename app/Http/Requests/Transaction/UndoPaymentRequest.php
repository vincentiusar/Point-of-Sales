<?php

namespace App\Http\Requests\Transaction;

use App\Constants\Transaction\TransactionConstant;
use Illuminate\Foundation\Http\FormRequest;

class UndoPaymentRequest extends FormRequest
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
        $this['transaction_id'] = $this->route('id');
        return [
            'transaction_id' => 'required|integer|exists:transactions,id,deleted_at,NULL',
        ];
    }
}
