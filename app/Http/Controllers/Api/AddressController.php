<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Exceptions\ServiceUnavailableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payer\PayerAddressShowRequest;
use App\Http\Resources\Payer\PayerAddressResource;
use App\Models\Currency;
use App\Models\Payer;
use App\Repositories\StoreRepository;
use App\Services\Payer\PayerAddressService;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

class AddressController extends Controller
{
    public function __construct(
        private readonly StoreRepository     $storeRepository,
        private readonly PayerAddressService $payerAddressService,
    )
    {
    }

    /**
     * @param PayerAddressShowRequest $request
     * @return PayerAddressResource
     */
    #[OA\Get(
        path: '/address/{payer}/{currency}',
        summary: 'Get static address for payer',
        tags: ['payer'],
        parameters: [
            new OA\Parameter(name: 'X-Api-Key', in: 'header', required: true,
                schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'payer', description: 'Your unique user ID', in: 'path', required: true,
                schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'currency', description: 'Currency example BTC.Bitcoin, USDT.Tron', in: 'path', required: true,
                schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: "Get static address", content: new OA\JsonContent(
                example: '{"result":{"blockchain":"bitcoin","currency":"BTC.Bitcoin","address":"bc1qwzefc7fp8tdlnv0es3pk6snad22hhet56c300461","payer":{"id":"9ff39a38-71e1-4a27-83f6-65312691e28e","storeUserId":"1"}},"errors":[]}',
            )),
            new OA\Response(response: 422, description: "Invalid route params", content: new OA\JsonContent(
                example: '{"message":"The payer can only contain uppercase and lowercase letters, a number and a symbol \'-\' (and 1 more error)","errors":{"payer":["The payer can only contain uppercase and lowercase letters, a number and a symbol \'-\'"],"currency":["Currency not found"]}}'
            )),
            new OA\Response(response: 401, description: "Unauthorized", content: new OA\JsonContent(
                example: '{"errors":["You don\'t have permission to this action!"],"result":[]}'
            )),
            new OA\Response(response: 403, description: "Static address generation is disabled in store settings", content: new OA\JsonContent(
                example: '{"errors":["Static address generation is disabled in store settings"],"result":[]}'
            )),
            new OA\Response(response: 503, description: "Store inactive", content: new OA\JsonContent(
                example: '{"errors":["Store inactive"],"result":[]}'
            )),
        ],

    )]
    public function getAddress(PayerAddressShowRequest $request)
    {
        $store = $this->storeRepository->getStoreByApiKey($request->header('X-Api-Key'));

        if (!$store->status) {
            throw new ServiceUnavailableException(message: "Store inactive");
        }

        if (!$store->static_addresses) {
            throw new ApiException(__('Static address generation is disabled in store settings'), Response::HTTP_FORBIDDEN);
        }

        $currency = Currency::where('id', $request->input('currency'))
            ->firstOrFail();

        $payer = Payer::firstOrCreate([
            'store_user_id' => $request->input('payer'),
            'store_id'      => $store->id,
        ]);

        return PayerAddressResource::make($this->payerAddressService->address($payer, $currency, $store));
    }
}
