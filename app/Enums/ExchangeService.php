<?php
declare(strict_types=1);

namespace App\Enums;

enum ExchangeService: string
{
    case Huobi = 'huobi';
    case Binance = 'binance';

    public function getId(): int
    {
        return match ($this) {
            ExchangeService::Huobi => 1,
            ExchangeService::Binance => 2,
        };
    }

    public function getTitle(): string
    {
        return match ($this) {
            ExchangeService::Huobi => 'Huobi',
            ExchangeService::Binance => 'Binance',
        };
    }

    public function getUrl(): string
    {
        return match ($this) {
            ExchangeService::Huobi => 'https://api.huobi.pro',
            ExchangeService::Binance => '',
        };
    }
}