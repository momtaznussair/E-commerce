<?php

namespace App\Http\Controllers\Api\Cart;

use App\Helpers\Cart;
use App\Traits\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartRequest;

class CartController extends Controller 
{
    use ApiResponse;
    protected $cart;

    public function __construct(Cart $cart) {
        $this->cart = $cart;
    }

    public function store(StoreCartRequest $request) {
        $this->cart->add($request->products);
        return $this->apiResponse(null, 'Cart Updated Successfully!');
    }
}
