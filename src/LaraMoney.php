<?php

namespace LaraMoney;

use Money\Money;

class LaraMoney extends Money{
    public function __toString()
    {
        return LaraMoneyHelper::moneyToString($this);
    }

    public function toString(string $locale): string
    {
        return LaraMoneyHelper::moneyToString($this, $locale);
    }
}