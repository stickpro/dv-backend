<?php
declare(strict_types=1);

namespace App\Services\Processing\Fake;

use App\Enums\Blockchain;
use App\Services\Processing\Contracts\OwnerContract;

class OwnerFake implements OwnerContract
{
    public function __construct(private readonly AddressFake $addressFake)
    {
    }

    public function createOwner(string $id): string
    {
        return fake()->uuid();
    }

    public function attachColdWalletWithAddress(Blockchain $blockchain, string $owner, string $address): string
    {
        return $address;
    }

    public function attachHotWalletWithMnemonic(Blockchain $blockchain, string $owner, string $mnemonic, string $passphrase): string
    {
        return $this->addressFake->generate($blockchain, $owner);
    }

    public function attachHotWalletWithPrivateKey(Blockchain $blockchain, string $owner, string $privateKey): string
    {
        return $this->addressFake->generate($blockchain, $owner);
    }
}