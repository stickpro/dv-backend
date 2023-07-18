<?php

namespace App\Services\Report;

use App\Enums\InvoiceStatus;
use App\Enums\TransactionType;
use App\Helpers\CommissionCalculation;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Balance\BalanceService;
use App\Services\Processing\Contracts\ProcessingWalletContract;
use Psr\SimpleCache\InvalidArgumentException;

readonly class ReportService
{
    public function __construct(
            private BalanceService          $balanceService,
            private ProcessingWalletContract $processingWalletService
    ) {
    }

    public static function make(...$params): static
    {
        return new static(...$params);
    }

    public function statsByUser(array $period, User $user): array
    {
        $sumInvoice = Transaction::whereBetween('created_at', $period)
                ->where('user_id', $user->id)
                ->where('type', TransactionType::Invoice->value)
                ->groupBy('currency_id')
                ->selectRaw('currency_id, SUM(amount) as total_amount')
                ->get();

        $invoiceStats = Invoice::whereBetween('created_at', $period)
                ->whereIn('store_id', $user->storesHolder->pluck('id'))
                ->selectRaw('COUNT(*) as count')
                ->selectRaw('SUM(CASE WHEN status = ? OR status = ? THEN 1 ELSE 0 END) as paid', [
                        InvoiceStatus::Paid->value,
                        InvoiceStatus::PartiallyPaid->value
                ])
                ->first();

        $sumTransfers = Transaction::whereBetween('created_at', $period)
                ->where('user_id', $user->id)
                ->selectRaw('COUNT(*) as count, currency_id')
                ->selectRaw('SUM(CASE WHEN type = ? THEN 1 ELSE 0 END) as transfer', [
                        TransactionType::Transfer->value
                ])
                ->groupBy('currency_id')
                ->get();

        $savedOnCommission = 0;

        foreach ($sumInvoice as $value) {
            $savedOnCommission += CommissionCalculation::savedOnCommission(
                    $value->currency_id,
                    $value->total_amount,
                    $sumTransfers->firstWhere('currency_id', $value->currency_id)->transfer);
        }


        $storesStat = $user->storesHolder()
                ->withSum('invoicesSuccess', 'amount')
                ->withCount('invoicesSuccess')
                ->get();

        return [
                'sum'               => $sumInvoice->sum('total_amount'),
                'sumTransfer'       => $sumTransfers->sum('transfer'),
                'invoice'           => [
                        'count' => $invoiceStats->count ?? 0,
                        'paid'  => $invoiceStats->paid ?? 0
                ],
                'savedOnCommission' => $savedOnCommission,
                'storesStat'        => $storesStat,
        ];
    }

    /**
     * @throws InvalidArgumentException
     */
    public function balanceByUser(User $user): array
    {
        $todaySum = Transaction::where('user_id', $user->id)
                ->whereDate('created_at', now()->today())
                ->where('type', TransactionType::Invoice->value)
                ->sum('amount');

        $yesterdaySum = Transaction::where('user_id', $user->id)
                ->whereDate('created_at', now()->yesterday())
                ->where('type', TransactionType::Invoice->value)
                ->sum('amount');

        $invoiceCount = Invoice::whereDate('created_at', now()->today())
                ->whereIn('store_id', $user->storesHolder->pluck('id'))
                ->count();

        $transactionCount = Transaction::where('user_id', $user->id)
                ->whereDate('created_at', now()->today())
                ->where('type', TransactionType::Invoice->value)
                ->count();

        $hotWalletsBalance = $this->balanceService->getAllBalanceFromProcessing($user);

        $processingWallets = $this->processingWalletService->getWallets($user->processing_owner_id);

        return [
                'todaySum'          => $todaySum,
                'yesterdaySum'      => $yesterdaySum,
                'invoiceCount'      => $invoiceCount,
                'transactionCount'  => $transactionCount,
                'balanceHotWallet'  => collect($hotWalletsBalance),
                'processingWallets' => $processingWallets
        ];
    }
}