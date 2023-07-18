<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Dto\ProcessingCallbackDto;
use App\Enums\Blockchain;
use App\Enums\InvoiceStatus;
use App\Enums\ProcessingCallbackType;
use App\Http\Requests\Processing\ProcessingCallbackRequest;
use App\Http\Resources\DefaultResponseResource;
use App\Http\Resources\Processing\ProcessingWalletCollection;
use App\Models\ProcessingCallback;
use App\Models\Store;
use App\Services\Processing\Contracts\ProcessingWalletContract;
use App\Services\Processing\ProcessingCallbackHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ProcessingController
 */
class ProcessingController extends ApiController
{
    /**
     * @param ProcessingCallbackHandler $callbackHandler
     * @param ProcessingWalletContract $processingWalletContract
     */
    public function __construct(
        private readonly ProcessingCallbackHandler $callbackHandler,
        private readonly ProcessingWalletContract $processingWalletContract
    )
    {
    }

    /**
     * @param ProcessingCallbackRequest $request
     * @return JsonResponse
     */
    public function callback(ProcessingCallbackRequest $request): JsonResponse
    {
        $input = $request->input();
        $input['status'] = InvoiceStatus::tryFrom($input['status'] ?? '');
        $input['blockchain'] = Blockchain::tryFrom($input['blockchain']);
        $input['type'] = ProcessingCallbackType::tryFrom($input['type']);

        ProcessingCallback::create(['request' => json_encode($request->all())]);

        $dto = new ProcessingCallbackDto($input);

        $this->callbackHandler->handle($dto);

        return (new DefaultResponseResource([]))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @param Request $request
     * @return ProcessingWalletCollection
     */
    public function getProcessingWallets(Request $request): ProcessingWalletCollection
    {
        $user = $request->user();

        $result = $this->processingWalletContract->getWallets($user->processing_owner_id);

        return new ProcessingWalletCollection($result);
    }
}