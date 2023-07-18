<?php

namespace App\Services\Exchange;

use App\Dto\Exchange\DepositAddressDto;
use App\Enums\ExchangeAddressType;
use App\Enums\ExchangeChainType;
use App\Enums\ExchangeService as ExchangeServiceEnum;
use App\Enums\HttpMethod;
use App\Exceptions\ApiException;
use App\Models\Currency;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class HuobiExchangeService extends AbstractExchange
{
    private ExchangeServiceEnum $serviceName = ExchangeServiceEnum::Huobi;

    private string $accessKey;
    private string $secretKey;
    protected string $nonce = '';
    protected array $data = [];
    protected string $type = '';
    protected string $path = '';
    protected string $signature = '';
    protected array $options = [];

    public function __construct(private readonly PendingRequest $client)
    {
        $this->client->withHeaders([
            'Content-Type' => 'application/json',
        ]);
    }

    public function getExchangeName(): string
    {
        return 'Huobi';
    }

    public function loadDepositAddress(): array
    {
        return $this->loadAddresses(ExchangeAddressType::Deposit);
    }

    public function loadWithdrawalAddress(): array
    {
        return $this->loadAddresses(ExchangeAddressType::Withdraw);
    }

    private function loadAddresses(ExchangeAddressType $addressType): array
    {
        $currencies = Currency::where('has_balance', true)->get();
        $addresses = [];

        foreach ($currencies as $currency) {
            $exchangeAddress = $this->getAddress($addressType, $currency->name->value);
            $exchangeAddress = $this->filterAddress($exchangeAddress);
            if (empty($exchangeAddress)) continue;
            foreach ($exchangeAddress as $address) {
                $dto = new DepositAddressDto([
                    'currency'       => $address->currency,
                    'exchangeUserId' => $address->userId ?? null,
                    'address'        => $address->address,
                    'chain'          => $address->chain,
                    'type'           => $addressType,
                ]);
                $this->saveExchangeAddress($dto, $this->accessKey, $addressType);
            }

            $addresses = array_merge($addresses, $exchangeAddress);
        }

        return $addresses;
    }

    public function loadSymbolsByCurrency(): Collection
    {
        return Cache::remember('symbols_by_currency', 3600, function () {
            $currencies = Currency::where('has_balance', true)
                ->get()
                ->pluck('code')
                ->map(fn($item) => strtolower($item->value));

            $symbols = collect($this->getSymbols());

            return $symbols->filter(fn($item) => $currencies->contains($item->{'base-currency'}))
                ->map(function ($item) {
                    return [
                        'fromCurrencyId' => $item->{'base-currency'},
                        'toCurrencyId'   => $item->{'quote-currency'},
                        'symbol'         => $item->symbol
                    ];
                })
                ->groupBy('fromCurrencyId');
        });
    }

    public function getExchangeSymbols(): Collection
    {
        return Cache::remember('exchange_by_currency', 3600, function () {
           return collect($this->getSymbols());
        });
    }

    public function calculateUsdt(string $symbol, float $amount)
    {
        $detail = $this->getMarketDetail(['symbol' => $symbol]);
        return $amount * $detail->tick->open;
    }

    public function calculateToken(string $symbol, float $amount)
    {
        $detail = $this->getMarketDetail(['symbol' => $symbol]);
        return $amount / $detail->tick->open;
    }

    public function setKeys(): void
    {
        $keys = $this->getKeys($this->serviceName);
        $this->accessKey = $keys['accessKey'];
        $this->secretKey = $keys['secretKey'];
    }

    protected function auth(): void
    {
        $this->nonce();
        $this->signature();
    }

    protected function signature(): void
    {
        if (empty($this->accessKey)) return;

        $param = [
            'AccessKeyId'      => $this->accessKey,
            'SignatureMethod'  => 'HmacSHA256',
            'SignatureVersion' => 2,
            'Timestamp'        => $this->nonce,
        ];

        $param = array_merge($param, $this->data);
        $param = $this->sort($param);

        $host_tmp = explode('https://', $this->config['apiUrl']);
        if (isset($host_tmp[1])) $temp = $this->type . "\n" . $host_tmp[1] . "\n" . $this->path . "\n" . implode('&', $param);
        $signature = base64_encode(hash_hmac('sha256', $temp ?? '', $this->secretKey, true));

        $param[] = "Signature=" . urlencode($signature);

        $this->signature = implode('&', $param);
    }


    protected function sort($param): array
    {
        $u = [];
        foreach ($param as $k => $v) {
            if (is_array($v)) $v = json_encode($v);
            $u[] = $k . "=" . urlencode($v);
        }
        asort($u);

        return $u;
    }

    protected function nonce(): void
    {
        $this->client->baseUrl($this->config['apiUrl']);
        $this->nonce = date('Y-m-d\TH:i:s', time());
    }


    /**
     * @throws \Exception
     */
    protected function exec(): PromiseInterface|Response
    {
        $this->auth();

        if (!empty($this->data) && $this->type != 'GET') {
            $this->options['body'] = json_encode($this->data);
        }
        if ($this->type == 'GET' && empty($this->accessKey)) {
            $this->signature = empty($this->data) ? '' : http_build_query($this->data);
        }

        $response = $this->client->send($this->type, $this->path . '?' . $this->signature, $this->options);

        if($response->object()->code !== 200) {
            throw new ApiException(__('Huobi Api exeption'), 400);
        }
        return $response;
    }

    private function filterAddress($addresses): array
    {
        return array_filter($addresses, fn($item) => in_array($item->chain, ExchangeChainType::values()));
    }

    private function getAddress(ExchangeAddressType $addressType, string $currencyName): array
    {
        $methodName = ($addressType === ExchangeAddressType::Deposit) ? 'getDepositAddress' : 'getWithdrawalAddress';
        return $this->$methodName(['currency' => strtolower($currencyName)]);
    }

    /**
     * @throws \Exception
     */
    protected function getDepositAddress(array $data)
    {
        $this->type = HttpMethod::GET->value;
        $this->path = '/v2/account/deposit/address';
        $this->data = $data;
        return $this->exec()->object()->data;
    }

    /**
     * @throws \Exception
     */
    protected function getWithdrawalAddress(array $data)
    {
        $this->type = HttpMethod::GET->value;
        $this->path = '/v2/account/withdraw/address';
        $this->data = $data;
        return $this->exec()->object()->data;
    }

    /**
     * @throws \Exception
     */
    protected function getSymbols(array $data = [])
    {
        $this->type = HttpMethod::GET->value;
        $this->path = 'v1/common/symbols';
        $this->data = $data;
        return $this->exec()->object()->data;
    }

    protected function getMarketDetail(array $data)
    {
        $this->type = HttpMethod::GET->value;
        $this->path = '/market/detail';
        $this->data = $data;
        return $this->exec()->object();
    }

}