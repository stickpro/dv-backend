<?php

namespace App\Enums;

enum WithdrawalRuleType: string
{
    case BalanceLimit = 'balance';
    case Interval = 'interval';
}
