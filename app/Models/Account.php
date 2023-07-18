<?php

namespace App\Models;

use App\Interface\Accountable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $id
 * @property User $user
 */
class Account extends Model implements Accountable
{
    use HasFactory;
    protected $fillable = ['user_id'];

    public function withdraw($amount, Account $to = null): Transaction
    {
        $lastTransaction = $this->getLastTransaction();

        $transaction = new Transaction();
        $transaction->account_id = $this->id;
        $transaction->amount = $amount;
        $transaction->last_balance = $lastTransaction->current_balance;
        $transaction->current_balance = $lastTransaction->current_balance-$amount;
        $transaction->type = empty($to) ? 'deposit' : 'transfer';
        $transaction->description = empty($to) ? 'Normal deposit' : 'Transfer to '.$to->user->email;
        $transaction->save();

        return $transaction;
    }

    public function deposit($amount, Account $from = null): Transaction
    {
        $lastTransaction = $this->getLastTransaction();

        $transaction = new Transaction();
        $transaction->account_id = $this->id;
        $transaction->amount = $amount;
        $transaction->last_balance = $lastTransaction->current_balance;
        $transaction->current_balance = $lastTransaction->current_balance+$amount;
        $transaction->type = empty($from) ? 'withdraw' : 'transfer';
        $transaction->description = empty($from) ? 'Normal withdraw' : 'Transfer from '.$from->user->email;
        $transaction->save();

        return $transaction;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transfer($amount, Account $to = null): Transaction
    {
        $transaction = $this->withdraw($amount, $to);
        $to->deposit($amount, $this);

        return $transaction;
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }
    public function getLastTransaction(): ?Transaction
    {
        return $this->transactions()->latest()->first();
    }
}
