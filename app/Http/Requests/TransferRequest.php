<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0', 'max:10000000'],
            'email' => 'exists:users,email'
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
            },
            function (Validator $validator) {
                if (auth()->user()->email == $this->validated()['email']) {
                    $validator->errors()->add('email', 'You cannot transfer to yourself!');
                }
            }
        ];
    }
}
