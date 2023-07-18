<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\DefaultResponseResource;
use App\Http\Resources\Transaction\TransactionInfoResource;
use App\Models\Invoice;
use App\Services\Transaction\TransactionService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * SupportController
 */
class SupportController extends ApiController
{
    /**
     * @param TransactionService $transactionService
     */
    public function __construct(private readonly TransactionService $transactionService)
    {
    }

    /**
     * @param Request $request
     * @param string $txId
     *
     * @return TransactionInfoResource
     * @throws InvalidArgumentException
     */
    public function getTransactionInfo(Request $request, string $txId): TransactionInfoResource
    {
        $result = $this->transactionService->getTransactionInfo($txId, $request->user(), $request->input('subDays'));

        return (new TransactionInfoResource($result));
    }

    /**
     * @param Request $request
     * @param string $txId
     * @param Invoice $invoice
     * @return DefaultResponseResource
     * @throws InvalidArgumentException
     * @throws \Throwable
     */
    public function attachTransactionToInvoice(Request $request, string $txId, Invoice $invoice): DefaultResponseResource
    {
        $user = $request->user();

        $this->transactionService->attachTransactionToInvoice($txId, $invoice, $user);

        return (new DefaultResponseResource([]));
    }

    /**
     * @param string $txId
     * @param Invoice $invoice
     * @param Authenticatable $user
     * @return void
     * @throws InvalidArgumentException
     * @throws \Throwable
     */
    public function forceAttachTransactionToInvoice(string $txId, Invoice $invoice, Authenticatable $user): DefaultResponseResource
    {
        $this->transactionService->forceAttachTransactionToInvoice($txId, $invoice, $user);
        return (new DefaultResponseResource([]));
    }

    public function attachTransactionToPayer(string $txId, Authenticatable $user)
    {
        $this->transactionService->attachTransactionToPayer($txId, $user);
        return (new DefaultResponseResource([]));

    }
}
