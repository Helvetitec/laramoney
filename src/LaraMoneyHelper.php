<?php

namespace LaraMoney;

use Exception;
use Illuminate\Support\Facades\App;
use LaraMoney\Exceptions\ParsingException;
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
     * @param bool $withSign
     * @return string
     */
    public static function moneyToString(Money $money, string $locale = null, bool $withSign = false): string
    {
        if($locale == null){
            $locale = App::getLocale();
        }
        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
        $sign = "";
        if($withSign){
            if(!$money->isZero()){
                $sign = $money->isPositive() ? "+" : "-";
            }
        }
        return $sign.$moneyFormatter->format($money);
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

    /**
     * Parses a string or array to a Money object
     *
     * @param mixed $value Can be either of type Money, string or array
     * @return Money
     * @throws ParsingException if value can't be parsed 
     */
    public static function parse(mixed $value): Money
    {
        //IF $value is already of type Money, we can return it as is
        if($value instanceof Money){
            return $value;
        }
        //If $value is an array, we assume that it contains of an "amount" key and a "currency" key
        if(is_array($value)){
            if(!array_key_exists("amount", $value) || !array_key_exists("currency", $value)){
                throw new ParsingException("Can't parse value, as it is an array and the array is missing either the key amount or currency.");
            }
            $amount = $value["amount"];
            if($value["currency"] instanceof Currency){
                $currency = $value["currency"];
            }elseif(is_string($value["currency"])){
                $currency = new Currency($value["currency"]);
            }else{
                throw new ParsingException("Can't parse value, as the currency is neither a Currency object nor a string.");
            }
            try{
                return new Money($amount, $currency);
            }catch(Exception $ex){
                throw new ParsingException($ex->getMessage());
            }
        }
        //If $value is something else, we try to parse it anyways which would most likely fail if its not a string or such
        try{
            return new Money($value, config('laramoney.default_currency', 'BRL'));
        }catch(Exception $ex){
            throw new ParsingException($ex->getMessage());
        }
    }
}