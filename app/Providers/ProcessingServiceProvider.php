<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Processing\BalanceGetter;
use App\Services\Processing\CallbackHandlers\PaymentCallback;
use App\Services\Processing\CallbackHandlers\TransferCallback;
use App\Services\Processing\CallbackHandlers\WatchCallback;
use App\Services\Processing\Contracts\AddressContract;
use App\Services\Processing\Contracts\Client as ProcessingClient;
use App\Services\Processing\Contracts\MnemonicContract;
use App\Services\Processing\Contracts\OwnerContract;
use App\Services\Processing\Contracts\ProcessingWalletContract;
use App\Services\Processing\Contracts\TransactionContract;
use App\Services\Processing\Contracts\TransferContract;
use App\Services\Processing\Fake\AddressFake;
use App\Services\Processing\Fake\MnemonicFake;
use App\Services\Processing\Fake\OwnerFake;
use App\Services\Processing\Fake\ProcessingWalletFake;
use App\Services\Processing\Fake\TransactionFake;
use App\Services\Processing\Fake\TransferFake;
use App\Services\Processing\FakeClient;
use App\Services\Processing\HttpClient;
use App\Services\Processing\ProcessingAddressService;
use App\Services\Processing\ProcessingCallbackHandler;
use App\Services\Processing\ProcessingService;
use App\Services\Processing\ProcessingTransactionService;
use App\Services\Processing\ProcessingWalletService;
use App\Services\Withdrawal\UnconfirmedWithdrawals;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class ProcessingServiceProvider extends ServiceProvider
{
    public function boot()
    {
//        todo remove if watch job work nice
//        $this->app->bind(WatchCallback::class, fn() => new WatchCallback(
//            $this->app->get(CurrencyConversion::class),
//            $this->app->get(Connection::class),
//            config('processing.min_transaction_confirmations')
//        ));

        if (config('processing.fake')) {
            $this->app->bind(ProcessingClient::class, fn() => new FakeClient());

            $this->app->bind(MnemonicContract::class, fn() => new MnemonicFake());
            $this->app->bind(AddressContract::class, fn() => new AddressFake());
            $this->app->bind(OwnerContract::class, fn() => new OwnerFake(new AddressFake()));
            $this->app->bind(TransactionContract::class, fn() => new TransactionFake());
            $this->app->bind(ProcessingWalletContract::class, fn() => new ProcessingWalletFake());
            $this->app->bind(TransferContract::class, fn() => new TransferFake());
            $this->app->bind(ProcessingCallbackHandler::class, fn() => new ProcessingCallbackHandler(
                    $this->app->get(WatchCallback::class),
                    $this->app->get(TransferCallback::class),
                    $this->app->get(PaymentCallback::class)
            ));
        } else {
            $httpClient = new Client([
                    'base_uri' => config('processing.url'),
            ]);

            $this->app->bind(ProcessingClient::class, fn() => new HttpClient(
                    $httpClient,
                    config('processing.client.id'),
                    config('processing.client.key'),
            ));

            $service = new ProcessingService(
                    $this->app->get(ProcessingClient::class)
            );

            $cb = fn() => $service;

            $this->app->bind(MnemonicContract::class, $cb);
            $this->app->bind(OwnerContract::class, $cb);
            $this->app->bind(TransferContract::class, $cb);
            $this->app->bind(AddressContract::class, fn() => new ProcessingAddressService(
                    $this->app->get(ProcessingClient::class),
                    (int) config('processing.multipliers.tron'),
                    (int) config('processing.multipliers.bitcoin')
            ));

            $this->app->bind(TransactionContract::class, fn() => new ProcessingTransactionService(
                    $this->app->get(ProcessingClient::class)
            ));

            $this->app->bind(ProcessingWalletContract::class, fn() => new ProcessingWalletService(
                    $this->app->get(ProcessingClient::class)
            ));
        }

        $this->app->bind(BalanceGetter::class, fn() => new BalanceGetter($this->app->get(ProcessingClient::class)));
        $this->app->bind(UnconfirmedWithdrawals::class, fn() => new UnconfirmedWithdrawals(
                new Client(['base_uri' => config('processing.btc_explorer')]),
        ));

        $this->app->bind(ProcessingCallbackHandler::class, fn() => new ProcessingCallbackHandler(
                watchHandler   : $this->app->get(WatchCallback::class),
                transferHandler: $this->app->get(TransferCallback::class),
                paymentHandler : $this->app->get(PaymentCallback::class)
        ));
    }
}
