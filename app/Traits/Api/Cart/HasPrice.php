<?php

namespace App\Traits\Api\Cart;

use App\Helpers\Money;

trait HasPrice {
    
    public function getFormattedPriceAttribute() {
        $money =  new Money($this->price);
        return $money->formatted();
    }

    public function setPriceAttribute($value) {
        $this->attributes['price'] = $value * 100;
    }
}