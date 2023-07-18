<?php

declare(strict_types=1);

namespace App\Http\Requests\Processing;

use App\Enums\Blockchain;
use App\Enums\InvoiceStatus;
use App\Enums\ProcessingCallbackType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * ProcessingCallbackRequest
 */
class ProcessingCallbackRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
                'id'              => ['string', 'nullable'],
                'type'            => [new Enum(ProcessingCallbackType::class), 'nullable'],
                'status'          => [new Enum(InvoiceStatus::class), 'nullable'],
                'invoice_id'      => ['string'],
                'tx'              => ['required', 'string'],
                'amount'          => ['string', 'nullable'],
                'blockchain'      => [new Enum(Blockchain::class), 'nullable'],
                'address'         => ['string', 'nullable'],
                'sender'          => ['string', 'nullable'],
                'contractAddress' => ['string', 'nullable'],
                'confirmations'   => ['string', 'nullable'],
                'time'            => ['string', 'nullable'],
                'payer_id'        => ['string', 'nullable']
        ];
    }
}
