<?php

declare(strict_types=1);

namespace App\Services\Processing\CallbackHandlers;

use App\Dto\ProcessingCallbackDto;
use App\Enums\CurrencySymbol;
use App\Enums\RateSource;
use App\Enums\TransactionType;
use App\Exceptions\CallbackException;
use App\Jobs\InvoiceAddressBalanceActualization;
use App\Models\Currency;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletBalance;
use App\Services\Balance\WalletBalanceService;
use App\Services\Currency\CurrencyConversion;
use App\Services\Currency\CurrencyRateService;
use App\Services\Processing\Contracts\CallbackHandlerContract;
use Illuminate\Database\Connection;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TransferCallback implements CallbackHandlerContract
{
    public function __construct(
        private readonly Connection           $db,
        private readonly CurrencyRateService  $currencyService,
        private readonly CurrencyConversion   $currencyConversion,
        private readonly WalletBalanceService $walletBalanceService
    )
    {
    }

    /**
     * @throws Throwable
     */
    public function handle(ProcessingCallbackDto $dto): void
    {
        try {
            $this->db->beginTransaction();

            if ((float)$dto->amount < 0) {
                throw new CallbackException(__('Negative amount.'), Response::HTTP_BAD_REQUEST);
            }

            $contractAddress = $dto->contractAddress ?? '';

            $currency = Currency::where([
                ['contract_address', $contractAddress],
                ['blockchain', $dto->blockchain],
            ])->first();
            $user = User::where('processing_owner_id', $dto->ownerId)->first();
//            $store = Store::where('processing_owner_id', $dto->ownerId)->first();
//            $wallet = Wallet::where([
//                ['store_id', $store->id],
//                ['address', $dto->address],
//                ['blockchain', $dto->blockchain],
//            ])->first();
//            $walletBalance = WalletBalance::where([
//                ['wallet_id', $wallet->id],
//                ['currency_id', $currency->id],
//            ])->first();

            $this->createTransaction($dto, $user, $currency);
//            $this->walletBalanceService->decrement($walletBalance, $dto->amount);

            $this->db->commit();

            InvoiceAddressBalanceActualization::dispatch($user->processing_owner_id);

        } catch (Throwable $e) {
            $this->db->rollBack();

            throw $e;
        }
    }

    private function createTransaction(ProcessingCallbackDto $dto, User $user, Currency $currency)
    {
        $rateSource = RateSource::Binance;
        $from = $currency->code;
        $to = CurrencySymbol::USDT;

        $data = $this->currencyService->getCurrencyRate($rateSource, $from, $to);
        $amountUsd = $this->currencyConversion->convert($dto->amount, $data['rate'], true);

        Transaction::create([
            'user_id' => $user->id,
//            'store_id' => $store->id,
            'currency_id' => $currency->id,
            'tx_id' => $dto->tx,
            'type' => TransactionType::Transfer,
            'from_address' => $dto->sender ?? '',
            'to_address' => $dto->address,
            'amount' => $dto->amount,
            'amount_usd' => $amountUsd,
            'rate' => $data['rate'],
            'fee' => 0,
            'withdrawal_is_manual' => $dto->isManual ?? false,
            'network_created_at' => $dto->time ?? null,
        ]);
    }
}
