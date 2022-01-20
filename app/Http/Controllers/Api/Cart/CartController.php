<?php

namespace App\Http\Controllers\Api\Cart;

use App\Helpers\Cart;
use App\Traits\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Resources\CartItemResource;

class CartController extends Controller 
{
    use ApiResponse;
    protected $cart;

    public function __construct(Cart $cart) {
        $this->cart = $cart;
    }

    public function index() {
        $items = CartItemResource::collection($this->cart->cart())
        ->additional($this->meta())
        ->response()
        ->getData();
        return $this->apiResponse($items, "User's Cart");
    }

    private function meta() {
        return [
            'meta' => [
                'isEmpty' => $this->cart->isEmpty(),
                'subTotal' => $this->cart->subtotal()->formatted(),
            ]
        ];
    }

    public function store(StoreCartRequest $request) {
        $this->cart->add($request->products);
        return $this->apiResponse(null, 'Cart Updated Successfully!');
    }

    public function update($product_id, UpdateCartRequest $request) {
        $this->cart->update($product_id, $request->quantity);
        return $this->apiResponse(null, 'Cart Item Updated Successfully!');
    }

    public function destroy($product_id) {
       $this->cart->delete($product_id);
       return $this->apiResponse(null, 'Cart Item Deleted Successfully!');
    }
}
