<?php

declare(strict_types=1);

namespace App\Services\Processing\Contracts;

use App\Enums\Blockchain;
use Psr\Http\Message\ResponseInterface;


interface TransferContract
{
    public function doTransfer(string $owner, Blockchain $blockchain, bool $isManual, string $contract = ''): ResponseInterface;
}
