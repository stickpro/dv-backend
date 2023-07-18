<?php

declare(strict_types=1);

namespace App\Services\Processing;

use App\Dto\ProcessingCallbackDto;
use App\Enums\ProcessingCallbackType;
use App\Services\Processing\Contracts\CallbackHandlerContract;

class ProcessingCallbackHandler
{
    public function __construct(
            private readonly CallbackHandlerContract $watchHandler,
            private readonly CallbackHandlerContract $transferHandler,
            private readonly CallbackHandlerContract $paymentHandler
    ) {
    }

    public function handle(ProcessingCallbackDto $dto): void
    {
        switch ($dto->type) {
            case ProcessingCallbackType::Expired:
            case ProcessingCallbackType::Watch:
                $this->watchHandler->handle($dto);
                break;
            case ProcessingCallbackType::Transfer:
                $this->transferHandler->handle($dto);
                break;
            case ProcessingCallbackType::Deposit:
                $this->paymentHandler->handle($dto);
                break;
        }
    }
}
