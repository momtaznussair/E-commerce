<?php

namespace App\Helpers;

use Money\Currency;
use NumberFormatter;
use Money\Money as BaseMoney;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;


class Money{
    protected $money;

    public function __construct($value, $currency = 'USD') {
       $this->money = new BaseMoney($value, new Currency($currency));
    }

    public function formatted($locale = 'en_US') {
        $formatter = new IntlMoneyFormatter(new NumberFormatter($locale, NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );
        return $formatter->format($this->money);
    }
}