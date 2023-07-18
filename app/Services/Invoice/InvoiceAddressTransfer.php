<?php

declare(strict_types=1);

namespace App\Services\Invoice;

use App\Models\Currency;
use App\Models\User;
use App\Models\UserInvoiceAddress;
use App\Services\Processing\ProcessingService;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * InvoiceAddressTransfer
 */
class InvoiceAddressTransfer
{
	/**
	 * @var string|mixed
	 */
	private ?string $addressFrom;
	/**
	 * @var string|mixed
	 */
	private ?string $currencyId;
	/**
	 * @var mixed|string|null
	 */
	private ?string $processingOwnerId;
	/**
	 * @var ProcessingService
	 */
	private ProcessingService $processingService;
	/**
	 * @var UserInvoiceAddress
	 */
	private UserInvoiceAddress $userInvoiceAddress;

	/**
	 * @param ProcessingService    $processingService
	 * @param UserInvoiceAddress   $userInvoiceAddress
	 * @param User|Authenticatable $user
	 */
	public function __construct(ProcessingService $processingService, UserInvoiceAddress $userInvoiceAddress, User|Authenticatable $user)
	{
		$this->addressFrom       = $userInvoiceAddress->address;
		$this->currencyId        = $userInvoiceAddress->currency_id;
		$this->processingOwnerId = $user->processing_owner_id;

		$this->processingService  = $processingService;
		$this->userInvoiceAddress = $userInvoiceAddress;
	}

	/**
	 * @return bool
	 * @throws \Throwable
	 */
	public function transfer(): UserInvoiceAddress
	{
		$currency = Currency::find($this->currencyId);

		if (!$this->processingService->transferFromAddress($this->addressFrom, $currency->blockchain, $this->processingOwnerId, $currency->contract_address)) {
			throw new Exception('Processing transfer error');
		}

		$this->userInvoiceAddress->balance_usd = 0;
		$this->userInvoiceAddress->balance     = 0;

		$this->userInvoiceAddress->saveOrFail();

		return $this->userInvoiceAddress;
	}
}
