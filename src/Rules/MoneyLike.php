<?php

namespace LaraMoney\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Money\Money;

class MoneyLike implements ValidationRule
{
    /**
     * Validates if the value can be parsed to a money object
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(is_null($value)){
            return;
        }elseif(is_array($value) && !is_null($value['amount'] ?? null) && !is_null($value['currency'] ?? null)){
            return;
        }elseif(is_numeric($value)){
            return;
        }elseif($value instanceof Money){
            return;
        }
        
        $fail('The :attribute must be castable to \Money\Money.');
    }
}