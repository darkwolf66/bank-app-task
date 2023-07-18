<?php

namespace App\Events;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use Dispatchable, SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        // Create a bank account for the user:
        $account = new Account();
        $account->user_id = $user->id;
        $account->save();

        // Create first transaction
        $transaction = new Transaction();
        $transaction->account_id = $account->id;
        $transaction->amount = 0;
        $transaction->last_balance = 0;
        $transaction->current_balance = 0;
        $transaction->description = 'Initial Transaction';
        $transaction->type = 'deposit';
        $transaction->save();

    }
}
