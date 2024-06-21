<?php

namespace LaraMoney;

use Exception;
use Illuminate\Support\Facades\App;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Money\MoneyParser;

class LaraMoneyHelper
{
    /**
     * Creates a string based on a money object and locale
     *
     * @param Money $money
     * @param string|null $locale
     * @return string
     */
    public static function moneyToString(Money $money, string $locale = null): string
    {
        if($locale == null){
            $locale = App::getLocale();
        }
        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
        return $moneyFormatter->format($money);
    }

    /**
     * Creates a money object based on value in cents and currency
     *
     * @param ?string $valueInCents
     * @param string $currencyCode
     * @return Money
     */
    public static function createMoney(?string $valueInCents, string|Currency $currency = "BRL"): Money{
        if(is_null($valueInCents)){
            $valueInCents = 0;
        }
        if(is_string($currency)){
            $currency = new Currency($currency);
        }
        return new Money($valueInCents, $currency);
    }

    /**
     * Creates a JSON array based on the Money object
     *
     * @param Money $money
     * @return string
     */
    public static function toJSON(Money $money): string
    {
        return json_encode($money);
    }

    public static function parse(mixed $value): Money
    {
        if(is_array($value)){
            return new Money($value["amount"], new Currency($value["currency"]));
        }
        if(is_numeric($value)){
            return new Money($value, config('laramoney.default_currency', 'BRL'));
        }
        throw new Exception("Can't parse value ".$value." only arrays and numeric values are supported");
    }
}