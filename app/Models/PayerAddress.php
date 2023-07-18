<?php

namespace App\Models;

use App\Enums\Blockchain;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayerAddress extends Model
{
    use SoftDeletes, HasUuid;

    protected $fillable = [
            'payer_id',
            'currency_id',
            'blockchain',
            'address',
    ];

    protected $casts = [
            'blockchain' => Blockchain::class,
    ];

    public function payer(): BelongsTo
    {
        return $this->belongsTo(Payer::class, 'payer_id', 'id');
    }

    public function currency(): HasOne
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

}
