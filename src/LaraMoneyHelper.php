<?php

namespace LaraMoney;

use Illuminate\Support\Facades\App;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

class LaraMoneyHelper
{
    /**
     * Creates a string based on a money object and locale
     *
     * @param Money $money
     * @param string|null $locale
     * @return string
     */
    public static function moneyToString(LaraMoney $money, string $locale = null): string
    {
        $money = $money->getMoney(); //Convert laramoney to money
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
    public static function createMoney(?string $valueInCents, string|Currency $currency = "BRL"): LaraMoney{
        if(is_null($valueInCents)){
            $valueInCents = 0;
        }
        if(is_string($currency)){
            $currency = new Currency($currency);
        }
        return new LaraMoney($valueInCents, $currency);
    }

    /**
     * Creates a JSON array based on the Money object
     *
     * @param LaraMoney $money
     * @return string
     */
    public static function toJSON(LaraMoney $money): string
    {
        return json_encode($money);
    }
}