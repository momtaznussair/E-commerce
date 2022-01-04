<?php

namespace App\Repositories\SQL;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;


class ProductRepository extends Repository implements ProductRepositoryInterface{

    public function __construct(Product $product)
    {
        Parent::__construct($product);
    }
}