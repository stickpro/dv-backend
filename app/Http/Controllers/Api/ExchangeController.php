<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Dto\Exchange\UserPairsDto;
use App\Dto\ExchangeKeyAddDto;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\Exchange\ExchangeRequest;
use App\Http\Requests\Exchange\UserPairsStoreRequest;
use App\Http\Requests\Exchange\WalletSettingsRequest;
use App\Http\Resources\DefaultResponseResource;
use App\Http\Resources\Exchange\UserPairsCollection;
use App\Models\ExchangeUserPairs;
use App\Models\Wallet;
use App\Services\Exchange\ExchangeService;
use App\Enums\ExchangeService as ExchangeServiceEnum;
use App\Services\Exchange\IExchangeManager;
use App\Services\Withdrawal\WithdrawalSettingService;
use Doctrine\DBAL\Schema\AbstractAsset;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Throwable;

/**
 * ExchangeController
 */
class ExchangeController extends ApiController
{
    /**
     * @param ExchangeService $exchangeService
     */
    public function __construct(
        private readonly ExchangeService          $exchangeService,
        private readonly WithdrawalSettingService $withdrawalSettingService
    )
    {
    }

    /**
     * @param Request $request
     *
     * @return DefaultResponseResource
     */
    public function getKeys(Request $request)
    {
        $user = $request->user();

        $keys = $this->exchangeService->getKeys($user);

        return new DefaultResponseResource($keys);
    }

    /**
     * @param Request $request
     *
     * @return DefaultResponseResource
     * @throws Throwable
     */
    public function addKeys(Request $request)
    {
        $user = $request->user();
        $input = $request->input();

        $dto = new ExchangeKeyAddDto([
            'exchange' => $input['exchange'],
            'keys' => $input['keys'],
            'user' => $user,
        ]);

        $this->exchangeService->addKey($dto);

        return new DefaultResponseResource([]);
    }

    /**
     * @throws GuzzleException
     * @throws Throwable
     */
    public function testConnection(Request $request)
    {
        $user = $request->user();
        $exchange = ExchangeServiceEnum::tryFrom($request->input('exchange'));

        $this->exchangeService->testConnection($user, $exchange);

        return new DefaultResponseResource([]);
    }

    private function getService(string $exchange, Authenticatable $user, IExchangeManager $exchangeManager)
    {
        $exchange = ExchangeServiceEnum::tryFrom($exchange);
        return $exchangeManager->make($exchange, $user);
    }

    public function depositAddresses(ExchangeRequest $request, Authenticatable $user, IExchangeManager $exchangeManager)
    {
        $service = $this->getService($request->input('exchange'), $user, $exchangeManager);
        $depositAddress = $service->loadDepositAddress();

        return new DefaultResponseResource($depositAddress);
    }

    public function withdrawalAddresses(ExchangeRequest $request, Authenticatable $user, IExchangeManager $exchangeManager)
    {
        $service = $this->getService($request->input('exchange'), $user, $exchangeManager);
        $withdrawalAddress = $service->loadWithdrawalAddress();

        return new DefaultResponseResource($withdrawalAddress);
    }

    public function symbols(ExchangeRequest $request, Authenticatable $user, IExchangeManager $exchangeManager)
    {
//        $service = $this->getService($request->input('exchange'), $user, $exchangeManager);
//        $symbolsByCurrency = $service->loadSymbolsByCurrency();
        $symbolsByCurrency = [
            'btc' => [
                [
                    "fromCurrencyId" => "btc",
                    "toCurrencyId" => "usdt",
                    "symbol" => "btcusdt"
                ],
                [
                    "fromCurrencyId" => "btc",
                    "toCurrencyId" => "eth",
                    "symbol" => "btceth"
                ],
            ],
            'usdt' => [
                [
                    "fromCurrencyId" => "usdt",
                    "toCurrencyId" => "btc",
                    "symbol" => "btcusdt"
                ],
                [
                    "fromCurrencyId" => "usdt",
                    "toCurrencyId" => "eth",
                    "symbol" => "ethusdt"
                ],
            ]
        ];

        return new DefaultResponseResource($symbolsByCurrency);
    }

    public function saveExchangeUserPairs(UserPairsStoreRequest $request, Authenticatable $user, IExchangeManager $exchangeManager)
    {
        $exchange = ExchangeServiceEnum::tryFrom($request->input('exchange'));

        $service = $this->getService($request->input('exchange'), $user, $exchangeManager);
        $dto = new UserPairsDto([
            'exchangeId' => $exchange->getId(),
            'userId' => $user->id,
            'currencyFrom' => $request->input('currencyFrom'),
            'currencyTo' => $request->input('currencyTo'),
            'via' => $request->input('currencyTo') !== 'usdt' ? 'usdt' : null,
            'symbol' => $request->input('symbol'),
        ]);

        $service->saveExchangeUserPairs($dto);
        return new DefaultResponseResource([]);
    }

    public function getExchangeUserPairs(ExchangeRequest $request, Authenticatable $user)
    {
        $exchange = ExchangeServiceEnum::tryFrom($request->input('exchange'));

        $exchangeUserPairs = ExchangeUserPairs::where('exchange_id', $exchange->getId())
            ->where('user_id', $user->id)
            ->get();

        return UserPairsCollection::make($exchangeUserPairs);
    }

    /**
     * @throws Throwable
     */
    public function updateExchangeWalletSetting(WalletSettingsRequest $request, Authenticatable $user, Wallet $wallet)
    {
        if ($user->cannot('update', $wallet)) {
            throw new UnauthorizedException(__("You don't have permission to this action!"));
        }

        $this->withdrawalSettingService->updateExchange($wallet, $request);
        return new DefaultResponseResource([]);
    }

}
