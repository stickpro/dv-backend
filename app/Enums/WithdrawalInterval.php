<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;
use ReflectionClass;

enum WithdrawalInterval: string
{
    use EnumToArray;

   // case Never = '0 2 31 2 1'; //  Feb 31st hack for cron not started
    case Never = '*/2 * * * *';
   // case Every30min = '*/30 * * * *';
    case Every30min = '*/1 * * * *';
    case Every2hours = '0 */2 * * *';
    case EverydayAt21 = '0 21 * * *';
    case EveryWeekdayAt00 = '0 0 * * 1-5';
    case EveryWeekdayEveryHour = '0 * * * 1-5';
    case EveryWeekdayEvery15Minutes = '*/15 7-19 * * 1-5';
    case EverySundayAt01 = '0 1 * * 0';
    case EveryFirstDayOfMonthAt00 = '0 0 1 * *';
    case EveryFirstSaturdayOfMonthAt15 = '0 0 1-7 * 6';
    case EveryFirstDayOfYearAt00 = '0 0 1 1 *';

    public function getName(): string
    {
        return match ($this) {
            self::Never => __('Never'),
            self::Every30min => __('Every 30 minutes'),
            self::Every2hours => __('Every two hours'),
            self::EverydayAt21 => __('Everyday at 21:00'),
            self::EveryWeekdayAt00 => __('Weekdays at 00:00'),
            self::EveryWeekdayEveryHour => __('Weekdays every hour'),
            self::EveryWeekdayEvery15Minutes => __('Weekdays from 07:00 to 19:00 every 15 minutes'),
            self::EverySundayAt01 => __('Sunday at 01:00'),
            self::EveryFirstDayOfMonthAt00 => __('Every first day of the month at 00:00'),
            self::EveryFirstSaturdayOfMonthAt15 => __('First Saturday each month at 15:00'),
            self::EveryFirstDayOfYearAt00 => __('First day of the year 00:00'),
        };
    }

    public static function getValue(): array
    {
        $reflection = new ReflectionClass(self::class);
        $constants = $reflection->getConstants();
        $keyValuePairs = [];

        foreach ($constants as $key => $value) {
            $keyValuePairs[$key] = $value;
        }

        return $keyValuePairs;
    }
}