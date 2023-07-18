<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Http\Requests\WithdrawRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    public function showDepositPage(Request $request): Response
    {
        return Inertia::render('Account/Deposit');
    }
    public function showWithdrawPage(Request $request): Response
    {
        return Inertia::render('Account/Withdraw', [
            'currentBalance' => $request->user()->account->getLastTransaction()->current_balance
        ]);
    }
    public function showTransferPage(Request $request): Response
    {
        return Inertia::render('Account/Transfer', [
            'currentBalance' => $request->user()->account->getLastTransaction()->current_balance
        ]);
    }
    public function processDeposit(Request $request): Response
    {
        $request->validate([
            'amount' => 'required|numeric|min:0|max:10000000',
        ], [
            'amount.max' => 'You can\'t deposit more than 10 million.',
            'amount.min' => 'You can\'t deposit less than 0.'
        ]);
        $amount = $request->input('amount');

        $account = $request->user()->account;

        $transaction = $account->deposit($amount);

        return Inertia::render('Account/Deposit', [
            'transaction' => $transaction
        ]);
    }
    public function processWithdraw(WithdrawRequest $request): Response
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);
        $amount = $request->input('amount');

        $account = $request->user()->account;

        $transaction = $account->withdraw($amount);

        return Inertia::render('Account/Withdraw', [
            'transaction' => $transaction,
            'currentBalance' => $transaction->current_balance
        ]);
    }
    public function processTransfer(TransferRequest $request): Response
    {
        $amount = $request->input('amount');

        $recipient = User::where('email', $request->input('email'))->first();

        $from = $request->user()->account;

        $transaction = $from->transfer($amount, $recipient->account);

        return Inertia::render('Account/Transfer', [
            'transaction' => $transaction,
            'currentBalance' => $transaction->current_balance
        ]);
    }
    public function showStatements(Request $request){
        $transactionList = $request->user()->account->transactions()->orderBy('created_at', 'desc')
            ->paginate(2);

        return Inertia::render('Account/Statements', [
            'transactions' => $transactionList,
            'currentBalance' => $request->user()->account->getLastTransaction()->current_balance
        ]);
    }
}
