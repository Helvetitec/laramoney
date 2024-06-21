<?php

namespace LaraMoney;

use Livewire\Wireable;
use Money\Currency;
use Money\Money;

class LaraMoney implements Wireable{

    private Money $money;

    public function __construct(int|string $amount, Currency $currency)
    {
        $this->money = new Money($amount, $currency);
    }

    public function add(LaraMoney ...$addends): LaraMoney
    {
        return static::convert($this->money->add(...$addends));
    }

    public function subtract(LaraMoney ...$subtrahends): LaraMoney
    {
        return static::convert($this->money->subtract(...$subtrahends));
    }

    public function multiply(int|string $multiplier, int $roundingMode = Money::ROUND_HALF_UP): LaraMoney
    {
        return static::convert($this->money->multiply($multiplier, $roundingMode));
    }

    public function divide(int|string $divisor, int $roundingMode = Money::ROUND_HALF_UP): LaraMoney
    {
        return static::convert($this->money->divide($divisor, $roundingMode));
    }

    public function mod(LaraMoney|int|string $divisor): LaraMoney
    {
        return static::convert($this->money->mod($divisor));
    }

    public function absolute(): LaraMoney
    {
        return static::convert($this->money->absolute());
    }

    public function negative(): LaraMoney
    {
        return static::convert($this->money->negative());
    }

    public function min(LaraMoney $first, LaraMoney ...$collection): LaraMoney
    {
        return static::convert($this->money->min($first, ...$collection));
    }

    public function max(LaraMoney $first, LaraMoney ...$collection): LaraMoney
    {
        return static::convert($this->money->max($first, ...$collection));
    }

    public function sum(LaraMoney $first, LaraMoney ...$collection): LaraMoney
    {
        return static::convert($this->money->sum($first, ...$collection));
    }

    public function avg(LaraMoney $first, LaraMoney ...$collection): LaraMoney
    {
        return static::convert($this->money->avg($first, ...$collection));
    }
    
    public function __toString()
    {
        return LaraMoneyHelper::moneyToString($this);
    }

    public function toString(string $locale): string
    {
        return LaraMoneyHelper::moneyToString($this, $locale);
    }

    public function getMoney(): Money
    {
        return $this->money;
    }
    
    public function toLivewire()
    {
        return [
            'amount' => $this->money->getAmount(),
            'currency' => $this->money->getCurrency()->getCode(),
        ];
    }
 
    public static function fromLivewire($value)
    {
        $amount = $value['amount'];
        $currency = $value['currency'];
        return new static($amount, new Currency($currency));
    }

    public function getAmount(): string
    {
        return $this->money->getAmount();
    }

    public function getCurrency(): Currency
    {
        return $this->money->getCurrency();
    }

    public static function convert(Money $money): LaraMoney
    {
        return new LaraMoney($money->getAmount(), $money->getCurrency());
    }
}