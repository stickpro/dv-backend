<?php

namespace App\Providers;

use App\Jobs\PaymentCallbackJob;
use App\Jobs\TransferJob;
use App\Jobs\WatchCallbackJob;
use App\Services\Currency\CurrencyConversion;
use App\Services\Currency\CurrencyRateService;
use App\Services\Invoice\InvoiceAddressCreator;
use App\Services\Invoice\InvoiceCreator;
use App\Services\Processing\Contracts\TransferContract;
use App\Services\Withdrawal\WithdrawalRuleManager;
use Illuminate\Support\ServiceProvider;

class WebhookServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->app->bindMethod([WatchCallbackJob::class, 'handle'], function ($job, $app) {
            return $job->handle(
                    config('processing.min_transaction_confirmations'),
                    $app->make(CurrencyConversion::class),
            );
        });

        $this->app->bindMethod([PaymentCallbackJob::class, 'handle'], function ($job, $app) {
            return $job->handle(
                    config('processing.min_transaction_confirmations'),
                    $app->get(InvoiceCreator::class),
                    $app->get(InvoiceAddressCreator::class),
                    $app->get(CurrencyRateService::class),
                    $app->get(CurrencyConversion::class),
            );
        });

        $this->app->bindMethod([TransferJob::class, 'handle'], function($job, $app) {
            return $job->handle(
                $app->get(WithdrawalRuleManager::class),
                $app->get(TransferContract::class)
            );
        });
    }
}
