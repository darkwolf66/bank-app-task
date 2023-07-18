<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $current_balance
 * @property int|mixed $last_balance
 * @property int|mixed $amount
 * @property mixed $account_id
 * @property int|mixed $description
 * @property mixed|string $type
 */
class Transaction extends Model
{
    protected $table = 'transactions';
    use HasFactory;
    protected $fillable = ['amount', 'last_balance', 'current_balance', 'type'];

    public function account(): void
    {
        $this->belongsTo(Account::class);
    }
}
