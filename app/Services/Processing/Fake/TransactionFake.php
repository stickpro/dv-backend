<?php
declare(strict_types=1);

namespace App\Services\Processing\Fake;

use App\Dto\ProcessingTransactionInfoDto;
use App\Enums\Blockchain;
use App\Services\Processing\Contracts\TransactionContract;
use DateTime;

class TransactionFake implements TransactionContract
{
    public function info(string $txId): ProcessingTransactionInfoDto
    {
//        $transaction = Transaction::where('tx_id', $txId)
//            ->firstOrFail();

        return new ProcessingTransactionInfoDto([
            'txId' => 'f4f4f4f4f',
            'amount' => 100,
            'time' => (new DateTime())->format(DATE_ATOM),
            'blockchain' => Blockchain::Tron,
            'contractAddress' => 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t',
            'sender' => fake()->uuid(),
            'receiver' => 'TKn5GuNb62KgQh7SLXznUrP33Naea0323d71',
            //'payerId' => '7ef76a4c-685b-4e0c-8a88-a9fd8b94c215',
            'confirmations' => 10,
            'watches' => [
                fake()->uuid(),
                fake()->uuid(),
                fake()->uuid(),
            ],
        ]);
    }

    public function attachTransactionToInvoice(string $txId, string $watchId, string $ownerId): void {}
}