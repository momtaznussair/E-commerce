<?php

namespace App\Helpers;

class Cart
{

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function add(array $products)
    {
        return $this->user->cart()->syncWithoutDetaching(
            $this->getStorePayload($products)
        );
    }

    public function update($productId, $quantity) {
        return $this->itemExists($productId) && $this->user->cart()->updateExistingPivot($productId, [
            'quantity' => $quantity,
        ]);
    }

    public function delete($productId) {
        return $this->itemExists($productId) && $this->user->cart()->detach($productId);
    }

    private function getStorePayload($products)
    {
        return collect($products)->keyBy('id')->map(function ($product) {
            return [
                'quantity' => $product['quantity'] + $this->getCurrentQuantity($product['id']),
            ];
        })
            ->toArray();
    }

    public function getCurrentQuantity($productId)
    {
        if ($product = $this->user->cart->where('id', $productId)->first()) {
            return $product->pivot->quantity;
        }
        return 0;
    }

    public function itemExists($productId) {
        return $product = $this->user->cart()
            ->where('product_variation_id', $productId)
            ->firstOrFail();
    }
}
