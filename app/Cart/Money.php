<?php

namespace App\Cart;

use NumberFormatter;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as BaseMoney;
use Money\Currency;

class Money
{
    protected $money;

    public function __construct($value)
    {
        $this->money = new BaseMoney($value, new Currency('GBP'));
    }

    public function formatted()
    {
        $formatter = new IntlMoneyFormatter(
            new NumberFormatter('en_GB', NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        return $formatter->format($this->money);
    }
}
