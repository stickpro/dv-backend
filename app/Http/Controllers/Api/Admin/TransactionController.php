<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\DefaultResponseResource;
use App\Http\Resources\Transaction\TransactionInfoResource;
use App\Models\Invoice;
use App\Services\Transaction\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends ApiController
{
    public function __construct(private readonly TransactionService $transactionService)
    {
    }

    public function getTransactionInfo(Request $request, string $txId): TransactionInfoResource
    {
        $result = $this->transactionService->getTransactionInfo($txId, $request->user(), $request->input('subDays'));

        return (new TransactionInfoResource($result));
    }

    public function attachTransactionToInvoice(Request $request, string $txId, Invoice $invoice): DefaultResponseResource
    {
	    $user = $request->user();

        $this->transactionService->attachTransactionToInvoice($txId, $invoice, $user);

        return (new DefaultResponseResource([]));
    }
}
