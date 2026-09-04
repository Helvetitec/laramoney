<?php

namespace LaraMoney\Facades;

use Illuminate\Support\Facades\Facade;
use LaraMoney\LaraMoney;
use Money\Money as MoneyMoney;
use Money\Currency;

/**
 * @method static string format(?Money $money, ?string $locale = null, bool $withSign = false, bool $allowNull = true)
 * @method static string formatCents(int $valueInCents, string|Currency $currency = "BRL", ?string $locale = null, bool $withSign = false)
 * @method static MoneyMoney zero(string|Currency $currency = "BRL")
 * @method static MoneyMoney make(string|int|null $valueInCents = null, string|Currency $currency = "BRL")
 * @method static string toJson(Money $money)
 * @method static MoneyMoney parse(Money|string|array $value, bool $convertNull = false)
 * @method static MoneyMoney getPercentage(Money $value, int $percentage)
 * @method static MoneyMoney difference(Money $value1, Money $value2, bool $absolute)
 * 
 * @see LaraMoney
 */
class Money extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laramoney';
    }
}