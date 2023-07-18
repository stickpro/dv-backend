<?php

namespace App\Services\Payer;

use App\Models\Currency;
use App\Models\Payer;
use App\Models\PayerAddress;
use App\Models\Store;
use App\Services\Processing\Contracts\AddressContract;

final readonly class PayerAddressService
{
    public function __construct(
            private AddressContract $contract,
    ) {
    }

    public function address(Payer $payer, Currency $currency, Store $store): PayerAddress
    {
        $address = $this->contract->getStaticAddress($currency, $payer, $store->user->processing_owner_id);

        return PayerAddress::firstOrCreate([
                'payer_id'    => $payer->id,
                'currency_id' => $currency->id,
                'blockchain'  => $currency->blockchain,
                'address'     => $address['address'],
        ]);
    }
}