<?php

namespace LaraMoney\Facades;

use Illuminate\Support\Facades\Facade;
use LaraMoney\LaraMoney;
use Money\Money as MoneyMoney;
use Money\Currency;

/**
 * @method static string format(?MoneyMoney $money, ?string $locale = null, bool $withSign = false, bool $allowNull = true)
 * @method static string formatCents(int $valueInCents, string|Currency $currency = "BRL", ?string $locale = null, bool $withSign = false)
 * @method static MoneyMoney zero(string|Currency $currency = "BRL")
 * @method static MoneyMoney make(string|int|null $valueInCents = null, string|Currency $currency = "BRL")
 * @method static string toJson(MoneyMoney $money)
 * @method static MoneyMoney parse(MoneyMoney|string|array $value, bool $convertNull = false)
 * @method static MoneyMoney getPercentage(MoneyMoney $value, int $percentage)
 * @method static MoneyMoney difference(MoneyMoney $value1, MoneyMoney $value2, bool $absolute = false)
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