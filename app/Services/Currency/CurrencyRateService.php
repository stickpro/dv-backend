<?php

declare(strict_types=1);

namespace App\Services\Currency;

use App\Enums\CurrencySymbol;
use App\Repositories\RateSourceRepository;
use App\ServiceLocator\RateSourceLocator;
use App\Models\Currency;
use App\Enums\RateSource;
use DateTime;
use Illuminate\Support\Facades\Log;

/**
 * CurrencyRateService
 */
class CurrencyRateService
{
    /**
     * @param RateSourceLocator $locator
     * @param CurrencyStore $currencyStore
     * @param RateSourceRepository $rateSourceRepository
     * @param CurrencyConversion $currencyConversion
     */
    public function __construct(
        private readonly RateSourceLocator    $locator,
        private readonly CurrencyStore        $currencyStore,
        private readonly RateSourceRepository $rateSourceRepository,
        private readonly CurrencyConversion   $currencyConversion
    )
    {
    }

    /**
     * @param RateSource|null $source
     * @return void
     */
    public function loadCurrencyRate(RateSource $source = null): void
    {
        if ($source) {
            $rateSources = [$this->rateSourceRepository->getByName($source->value)];
        } else {
            $rateSources = $this->rateSourceRepository->getActualRateSources();
        }

        $currencies = $this->generateAllCurrencyPairs();

        foreach ($rateSources as $rateSource) {
            try {
                $rateSourceName = $rateSource->name;
                $rateSourceService = $this->locator->getRateSourceService($rateSourceName);
                if (!$rateSourceService) {
                    continue;
                }

                $rateSourceService->loadCurrencyPairs($rateSource->uri, $currencies);
            } catch (\Throwable $e) {
                $msg = 'Exception in loadCurrencyRate. ' . $rateSource->name->value . ': ' . $e->getMessage() . ': ' . $e->getTraceAsString();
                Log::error($msg);

                continue;
            }
        }
    }

    /**
     * @param RateSource $source
     * @param CurrencySymbol $from
     * @param CurrencySymbol $to
     * @return array|null
     */
    public function getCurrencyRate(RateSource $source, CurrencySymbol $from, CurrencySymbol $to): ?array
    {
        if ($from == CurrencySymbol::USD) {
            $from = CurrencySymbol::USDT;
        }

        if ($to == CurrencySymbol::USD) {
            $to = CurrencySymbol::USDT;
        }

        if ($from == $to) {
            return [
                'rate' => '1',
                'lastUpdate' => new DateTime(),
            ];
        }

        if ($data = $this->getRate($source, $from, $to)) {
            return $data;
        }

        $this->loadCurrencyRate($source);

        return $this->getRate($source, $from, $to);
    }

    /**
     * @param RateSource $source
     * @param CurrencySymbol $from
     * @param CurrencySymbol $to
     * @return array|null
     */
    private function getRate(RateSource $source, CurrencySymbol $from, CurrencySymbol $to): ?array
    {
        if ($data = $this->currencyStore->get($source, $from, $to)) {
            return $data;
        }

        if ($data = $this->currencyStore->get($source, $to, $from)) {
            $data['rate'] = number_format(
                1 / $data['rate'],
                8,
                '.',
                ''
            );

            return $data;
        }

        return null;
    }

    /**
     * @return array
     */
    private function generateAllCurrencyPairs(): array
    {
        $result = [];

        $currencies = Currency::all();

        foreach ($currencies as $from) {
            foreach ($currencies as $to) {
                if ($from->code == $to->code) {
                    continue;
                }

                $result[] = [
                    'from' => $from->code,
                    'to' => $to->code,
                ];
            }
        }

        return $result;
    }

    /**
     * Get the exchange rate for all currency pairs
     *
     * @return array
     */
    public function getAllRates(): array
    {
        $dt = new DateTime();

        $rateSources = $this->rateSourceRepository->getActualRateSources();
        $currencyPairs = $this->generateAllCurrencyPairs();

        $result = [];
        foreach ($rateSources as $rateSource) {
            foreach ($currencyPairs as $currencyPair) {
                $data = $this->getCurrencyRate(
                    $rateSource->name,
                    $currencyPair['from'],
                    $currencyPair['to']
                );

                if (!$data) {
                    $rate = '0';
                    $lastUpdate = $dt->format(DATE_ATOM);
                } else {
                    $rate = $data['rate'];
                    $lastUpdate = $data['lastUpdate']->format(DATE_ATOM);
                }

                $result[$rateSource->name->value][] = [
                    'from' => $currencyPair['from']->value,
                    'to' => $currencyPair['to']->value,
                    'rate' => $rate,
                    'lastUpdate' => $lastUpdate,
                ];
            }
        }

        return $result;
    }

	/**
	 * @param RateSource     $rateSource
	 * @param CurrencySymbol $from
	 * @param CurrencySymbol $to
	 * @param string         $amount
	 * @param bool           $reverseRate
	 *
	 * @return string
	 */
	public function inUsd(RateSource $rateSource, CurrencySymbol $from, CurrencySymbol $to, string $amount, bool $reverseRate = false): string
    {
        $data = $this->getCurrencyRate($rateSource, $from, $to);

        return $this->currencyConversion->convert($amount, $data['rate'], $reverseRate);
    }
}