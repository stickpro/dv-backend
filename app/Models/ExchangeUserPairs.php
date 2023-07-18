<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangeUserPairs extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'exchange_id',
        'user_id',
        'currency_from',
        'currency_to',
        'symbol',
        'via'
    ];
}
