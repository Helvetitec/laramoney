<?php

namespace LaraMoney\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Database\Eloquent\Model;
use LaraMoney\LaraMoneyHelper;
use Money\Currency;
use Money\Money;

class LaraMoney implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): Money
    {
        $json = json_decode($value, true);
        return LaraMoneyHelper::createMoney(
            $json["amount"],
            new Currency($json["currency"])
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if($value instanceof Money){
            return json_encode($value);
        }
        throw new InvalidCastException($model, $key, $value);
    }
}
