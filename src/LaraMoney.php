<?php

namespace LaraMoney;

use Livewire\Wireable;
use Money\Currency;
use Money\Money;

class LaraMoney extends Money implements Wireable{

    public function __construct(int|string $amount, Currency $currency)
    {
            parent::__construct($amount, $currency);
    }

    public function add(LaraMoney ...$addends): LaraMoney
    {
        return parent::add(...$addends);
    }

    public function subtract(LaraMoney ...$subtrahends): LaraMoney
    {
        return parent::subtract(...$subtrahends);
    }

    public function multiply(int|string $multiplier, int $roundingMode = self::ROUND_HALF_UP): LaraMoney
    {
        return parent::multiply($multiplier, $roundingMode);
    }

    public function divide(int|string $divisor, int $roundingMode = self::ROUND_HALF_UP): LaraMoney
    {
        return parent::divide($divisor, $roundingMode);
    }

    public function mod(LaraMoney|int|string $divisor): LaraMoney
    {
        return parent::mod($divisor);
    }

    public function absolute(): LaraMoney
    {
        return parent::absolute();
    }

    public function negative(): LaraMoney
    {
        return parent::negative();
    }

    public function min(LaraMoney $first, LaraMoney ...$collection): LaraMoney
    {
        return parent::min($first, ...$collection);
    }

    public function max(LaraMoney $first, LaraMoney ...$collection): LaraMoney
    {
        return parent::max($first, ...$collection);
    }

    public function sum(LaraMoney $first, LaraMoney ...$collection): LaraMoney
    {
        return parent::sum($first, ...$collection);
    }

    public function avg(LaraMoney $first, LaraMoney ...$collection): LaraMoney
    {
        return parent::avg($first, ...$collection);
    }
    
    public function __toString()
    {
        return LaraMoneyHelper::moneyToString($this);
    }

    public function toString(string $locale): string
    {
        return LaraMoneyHelper::moneyToString($this, $locale);
    }

    public function toLivewire()
    {
        return [
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency()->getCode(),
        ];
    }
 
    public static function fromLivewire($value)
    {
        $amount = $value['amount'];
        $currency = $value['currency'];
        return new static($amount, new Currency($currency));
    }
}