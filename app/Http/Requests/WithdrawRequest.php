<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class WithdrawRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0', 'max:10000000'],
        ];
    }
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $requestedAmount = $this->validated()['amount'];
                $currentBalance = auth()->user()->account->getLastTransaction()->current_balance;
                if ($currentBalance < $requestedAmount) {
                    $validator->errors()->add('amount', 'Insufficient balance.');
                }
            }
        ];
    }
}
