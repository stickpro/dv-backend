<?php

declare(strict_types=1);

namespace App\Services\Processing;

use App\Dto\ProcessingTransactionInfoDto;
use App\Enums\Blockchain;
use App\Enums\HttpMethod;
use App\Exceptions\ProcessingException;
use App\Services\Processing\Contracts\Client;
use App\Services\Processing\Contracts\TransactionContract;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProcessingTransactionService implements TransactionContract
{
    public function __construct(private readonly Client $client)
    {
    }

    public function info(string $txId): ProcessingTransactionInfoDto
    {
        $response = $this->client->request(HttpMethod::GET, "/transactions/$txId", []);

        if ($response->getStatusCode() != Response::HTTP_OK) {
            throw new NotFoundHttpException(__('Transaction not found.'));
        }

        $response = json_decode((string)$response->getBody(), true);
        $response['blockchain'] = Blockchain::tryFrom($response['blockchain']);

        return new ProcessingTransactionInfoDto($response);
    }

    public function attachTransactionToInvoice(string $txId, string $watchId, string $ownerId): void
    {
        $response = $this->client->request(HttpMethod::POST, "/owners/$ownerId/transactions/$txId/watches/$watchId", []);

	    Log::channel('supportLog')->info('Attach transaction to invoice processing response', [$response->getBody()]);

        if ($response->getStatusCode() == Response::HTTP_BAD_REQUEST) {
            throw new ProcessingException(__('Transaction can not be set.'), $response);
        }

        if ($response->getStatusCode() == Response::HTTP_CONFLICT) {
            throw new ProcessingException(__('Transaction has invoice.'), $response);
        }

        if ($response->getStatusCode() != Response::HTTP_OK) {
            throw new ProcessingException(__('Transaction not set.'), $response);
        }
    }
}
