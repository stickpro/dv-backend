<?php

namespace App\Services\Exchange;

use App\Enums\ExchangeService as ExchangeServiceEnum;
use App\Exceptions\ApiException;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Client\PendingRequest;

class ExchangeManager implements IExchangeManager
{
    private mixed $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @throws \Exception
     */
    public function make(ExchangeServiceEnum $service, Authenticatable|User $user)
    {
        $exchangeName = $service->getTitle();
        $createMethod = 'create' . ucfirst($exchangeName) . 'ExchangeService';
        if (!method_exists($this, $createMethod)) {
            throw new ApiException("Exchange $exchangeName is not supported", 403);
        }

        return $this->{$createMethod}($user);
    }

    private function createHuobiExchangeService(Authenticatable|User $user)
    {
        $config = $this->app['config']['exchange.huobi'];
        $service = HuobiExchangeService::make(app(PendingRequest::class));
        $service->setConfig($config);
        $service->setUser($user);
        $service->setKeys();
        return $service;
    }
}