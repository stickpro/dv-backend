<?php

declare(strict_types=1);

namespace App\Services\Mnemonic;

use App\Enums\Blockchain;
use App\Models\Currency;
use App\Models\User;
use App\Services\Processing\Contracts\MnemonicContract;
use App\Services\Processing\Contracts\OwnerContract;

class MnemonicService
{
    public function __construct(
        private readonly MnemonicContract $mnemonicContract,
        private readonly OwnerContract $ownerContract
    )
    {
    }

    public function createPhrase(?int $size): string
    {
        if ($size) {
            $phrase = $this->mnemonicContract->generate($size);
        } else {
            $phrase = $this->mnemonicContract->generate();
        }

        return $phrase;
    }

    public function attachToProcessing(User $user, string $phrase, ?string $passPhrase): void
    {
        $blockchains = Blockchain::cases();
        foreach ($blockchains as $blockchain) {
            $currencyExists = Currency::where([
                ['blockchain', $blockchain],
                ['has_balance', true],
            ])->exists();

            if (!$currencyExists) {
                continue;
            }

            $passPhrase = $passPhrase ?? '';

            $this->ownerContract->attachHotWalletWithMnemonic($blockchain, $user->processing_owner_id, $phrase, $passPhrase);
        }
    }
}