<?php

namespace LaraMoney;

use Livewire\Wireable;
use Money\Currency;
use Money\Money;

class WireMoney extends Money implements Wireable{
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