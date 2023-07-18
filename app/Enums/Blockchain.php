<?php

declare(strict_types=1);

namespace App\Enums;

enum Blockchain: string
{
    case Tron = 'tron';
    case Bitcoin = 'bitcoin';
    case Ethereum = 'ethereum';

    public function getNativeToken(): CurrencySymbol
    {
        return match ($this) {
            self::Tron => CurrencySymbol::TRX,
            self::Bitcoin => CurrencySymbol::BTC,
            self::Ethereum => CurrencySymbol::ETH,
        };
    }

    public function getChain(): string
    {
        return match ($this) {
            self::Tron => 'trc20usdt',
            self::Bitcoin => 'btc',
            self::Ethereum => 'eth',
        };
    }

    public function getCurrency(): string
    {
        return match ($this) {
            self::Tron => 'usdt',
            self::Bitcoin => 'btc',
            self::Ethereum => 'eth',
        };
    }


    public function getExplorerUrl(): string
    {
        return match ($this) {
            self::Tron => 'https://tronscan.org/#/transaction',
            self::Bitcoin => 'https://www.blockchain.com/btc/tx',
        };
    }

    public function getWalletExplorerUrl(): string
    {
        return match ($this) {
            self::Tron => 'https://apilist.tronscanapi.com/api/accountv2?address=',
            self::Bitcoin => 'https://blockchain.info/rawaddr/',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
