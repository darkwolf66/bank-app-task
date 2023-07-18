<?php

namespace App\Interface;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface Accountable
{
    public function transactions(): HasMany;
    public function withdraw($amount): Transaction;
    public function deposit($amount): Transaction;
    public function transfer($amount, Account $to): Transaction;
}
