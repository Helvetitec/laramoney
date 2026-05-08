<?php

namespace LaraMoney;

use Exception;
use Illuminate\Support\Facades\App;
use LaraMoney\Exceptions\ParsingException;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

class LaraMoney
{
    /**
     * Creates a string based on a money object and locale
     *
     * @param ?Money $money
     * @param string|null $locale
     * @param bool $withSign
     * @param bool $allowNull
     * @return string
     */
    public function format(?Money $money, ?string $locale = null, bool $withSign = false, bool $allowNull = true): string
    {
        if(!$allowNull && is_null($money)){
            throw new \LaraMoney\Exceptions\ParsingException("Can't format value because money is null but allowNull is false.");
        }elseif($allowNull && is_null($money)){
            $money = $this->zero(config('laramoney.default_currency', 'BRL'));
        }
        if($locale == null){
            $locale = App::getLocale();
        }
        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
        $sign = "";
        if($withSign){
            if(!$money->isZero() && $money->isPositive()){
                $sign = "+";
            }
        }
        return $sign.$moneyFormatter->format($money);
    }

    /**
     * Converts a value in cents directly to a string
     *
     * @param integer $valueInCents
     * @param string $currency
     * @param string|null $locale
     * @param boolean $withSign
     * @return string
     */
    public function formatCents(int $valueInCents, string|Currency $currency = "BRL", ?string $locale = null, bool $withSign = false): string
    {
        $money = $this->make($valueInCents, $currency);
        return $this->format($money, $locale, $withSign);
    }

    /**
     * Creates a money object sets the value to 0 and uses currency
     *
     * @param string $currency
     * @return Money
     */
    public function zero(string|Currency $currency = "BRL"): Money{
        return $this->make(0, $currency);
    }

    /**
     * Creates a money object based on value in cents and currency
     *
     * @param ?string $valueInCents
     * @param string $currency
     * @return Money
     */
    public function make(?string $valueInCents = null, string|Currency $currency = "BRL"): Money{
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
    public function toJson(Money $money): string
    {
        return json_encode($money);
    }

    /**
     * Parses a string or array to a Money object
     *
     * @param mixed $value Can be either of type Money, string or array
     * @param bool $convertNull If set to true, a NULL $value will be converted to int 0
     * @return Money
     * @throws ParsingException if value can't be parsed 
     */
    public function parse(mixed $value, bool $convertNull = false): Money
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
        
        //If $value is null and $convertNull is true, a new Money object is generated with the value 0
        if($convertNull && is_null($value))
        {
            return new Money(0, new Currency(config('laramoney.default_currency', 'BRL')));
        }

        //If $value is something else, we try to parse it anyways which would most likely fail if its not a string or such
        try{
            return new Money($value, new Currency(config('laramoney.default_currency', 'BRL')));
        }catch(Exception $ex){
            throw new ParsingException($ex->getMessage());
        }
    }

    /**
     * Returns a monetary value based on the percentage $percentage of $value. For example, if $value is USD 100 and $percentage is 10, the returned value would be USD 10
     *
     * @param Money $value
     * @param integer $percentage
     * @return Money
     */
    public function getPercentage(Money $value, int $percentage): Money
    {
        return $value->multiply($percentage)->divide(100);
    }
}