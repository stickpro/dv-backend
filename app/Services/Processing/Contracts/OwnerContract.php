<?php
declare(strict_types=1);

namespace App\Services\Processing\Contracts;

use App\Enums\Blockchain;

interface OwnerContract
{
    /**
     * Creates a new owner of wallets
     *
     * @param string $id
     * @return string
     */
    public function createOwner(string $id): string;

    /**
     * attaches cold wallet to owner with address
     *
     * @param Blockchain $blockchain
     * @param string $address
     * @param string|null $mnemonic
     * @param string $passphrase
     * @return string
     */
    public function attachColdWalletWithAddress(Blockchain $blockchain, string $owner, string $address): string;

    /**
     * attaches hot wallet with mnemonic phrase
     *
     * @param Blockchain $blockchain
     * @param string $owner
     * @param string $mnemonic
     * @param string $passphrase
     * @return string
     */
    public function attachHotWalletWithMnemonic(Blockchain $blockchain, string $owner, string $mnemonic, string $passphrase): string;

    /**
     * attaches hot wallet with private key
     *
     * @param Blockchain $blockchain
     * @param string $owner
     * @param string $privateKey
     * @return string
     */
    public function attachHotWalletWithPrivateKey(Blockchain $blockchain, string $owner, string $privateKey): string;
}