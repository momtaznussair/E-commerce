<?php

namespace App\Repositories\SQL;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;


class ProductRepository extends Repository implements ProductRepositoryInterface{

    public function __construct(Product $product)
    {
        Parent::__construct($product);
    }

    public function getBySlug($product) {
        return $this->model->where('slug', $product)
        ->with('variations.type')
        ->firstOrFail();
    }
}