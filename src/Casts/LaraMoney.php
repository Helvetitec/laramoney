<?php

namespace LaraMoney\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Database\Eloquent\Model;
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
        return new Money($value[0], new Currency($value[1]));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if($value instanceof Money){
            return [
                $value->getAmount(),
                $value->getCurrency()->getCode()
            ];
        }
        throw new InvalidCastException($model, $key, $value);
    }
}
