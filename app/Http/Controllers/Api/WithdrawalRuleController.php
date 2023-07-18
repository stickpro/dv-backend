<?php

namespace App\Http\Controllers\Api;

use App\Enums\WithdrawalInterval;
use App\Http\Controllers\Controller;
use App\Http\Requests\Withdrawal\WithdrawalIntervalRequest;
use App\Http\Resources\DefaultResponseResource;
use Illuminate\Contracts\Auth\Authenticatable;

class WithdrawalRuleController extends Controller
{
    public function index(Authenticatable $user): DefaultResponseResource
    {
        return DefaultResponseResource::make([
            'withdrawalIntervalCron' => $user->settings->get('withdrawal_interval'),
            'withdrawalMinBalance' => $user->settings->get('withdrawal_min_balance'),
        ]);
    }

    /**
     * @throws \Exception
     */
    public function store(WithdrawalIntervalRequest $request, Authenticatable $user): DefaultResponseResource
    {
        $user->settings->set('withdrawal_interval', $request->input('withdrawalIntervalCron'));
        $user->settings->set('withdrawal_min_balance', $request->input('withdrawalMinBalance'));

        $user->wallets()->update([
            'withdrawal_interval_cron' => $request->input('withdrawalIntervalCron'),
            'withdrawal_min_balance' => $request->input('withdrawalMinBalance')
        ]);

        return DefaultResponseResource::make([]);
    }

}
