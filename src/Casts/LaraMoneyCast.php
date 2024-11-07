<?php

namespace LaraMoney\Casts;

use Exception;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use LaraMoney\LaraMoneyHelper;
use Money\Currency;
use Money\Money;

class LaraMoneyCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Money
    {
        if(is_null($value) || trim($value) == ''){
            return config('laramoney.casts_null', false) ? null : LaraMoneyHelper::createMoney(0, config('laramoney.default_currency', 'BRL'));
        }
        $json = json_decode($value, true);
        return new Money($json["amount"], new Currency($json["currency"]));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if(is_null($value)){
            return null;
        }
        if(is_array($value)){
            $value = LaraMoneyHelper::createMoney($value["amount"] * (config('laramoney.values_in_cents', false) ? 1 : 100), $value["currency"]);
        }
        if(is_numeric($value)){
            $value = LaraMoneyHelper::createMoney($value * (config('laramoney.values_in_cents', false) ? 1 : 100), config('laramoney.default_currency', 'BRL'));
        }
        if(!$value instanceof Money){
            throw new Exception("Value is not an instance of Money\Money. => ".$value);
        }
        return json_encode($value);
    }
}
