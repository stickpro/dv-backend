<?php

namespace App\Http\Requests\Withdrawal;

use App\Enums\WithdrawalInterval;
use App\Rules\EnumKeyRule;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawalIntervalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'withdrawalMinBalance' => ['required', 'integer'],
            'withdrawalIntervalCron' => ['required', 'string', new EnumKeyRule(WithdrawalInterval::class)]
        ];
    }

}
