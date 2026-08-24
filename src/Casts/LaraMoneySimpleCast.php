<?php

namespace LaraMoney\Casts;

use Exception;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use LaraMoney\Facades\Money as FacadesMoney;
use Money\Currency;
use Money\Money;

class LaraMoneySimpleCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Money
    {
        if(is_null($value) || trim($value) == ''){
            return config('laramoney.casts_null', false) ? null : FacadesMoney::make(0, config('laramoney.default_currency', 'BRL'));
        }
        $currency = $model->currency ?? config('laramoney.default_currency', 'BRL');
        return new Money($value, new Currency($currency));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string|null
    {
        if(is_null($value)){
            return null;
        }
        if(is_array($value)){
            $value = FacadesMoney::make($value["amount"] * (config('laramoney.values_in_cents', false) ? 1 : 100), $value["currency"]);
        }
        if(is_numeric($value)){
            $value = FacadesMoney::make($value * (config('laramoney.values_in_cents', false) ? 1 : 100), config('laramoney.default_currency', 'BRL'));
        }
        if(!$value instanceof Money){
            throw new Exception("Value is not an instance of Money\Money. => ".$value);
        }
        return $value->getAmount();
    }
}
