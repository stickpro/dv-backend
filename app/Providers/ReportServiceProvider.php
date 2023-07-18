<?php

namespace App\Providers;

use App\Services\Balance\BalanceService;
use App\Services\Processing\Contracts\ProcessingWalletContract;
use App\Services\Report\ReportService;
use App\Services\Telegram\Commands\BalanceCommand;
use App\Services\Telegram\Commands\BaseCommand;
use App\Services\Telegram\Commands\ReportCommand;
use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->app->bind(ReportService::class, fn() => new ReportService(
                $this->app->get(BalanceService::class),
                $this->app->get(ProcessingWalletContract::class)
        ));

    }
}
