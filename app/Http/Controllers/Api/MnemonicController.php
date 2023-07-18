<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Mnemonic\CreateMnemonicPhraseRequest;
use App\Http\Resources\DefaultResponseResource;
use App\Services\Mnemonic\MnemonicService;
use Illuminate\Http\JsonResponse;

class MnemonicController extends ApiController
{
    public function __construct(
        private readonly MnemonicService $mnemonicService
    )
    {
    }

    public function create(CreateMnemonicPhraseRequest $request): JsonResponse
    {
        $user = $request->user();
        $input = $request->input();

        $phrase = $this->mnemonicService->createPhrase($input['size'] ?? null);

        $this->mnemonicService->attachToProcessing($user, $phrase, $input['passPhrase'] ?? null);

        return (new DefaultResponseResource([$phrase]))
            ->response();
    }
}