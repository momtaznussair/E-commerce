<?php

namespace App\Repositories\Contracts;
interface ProductRepositoryInterface extends RepositoryInterface{
    public function getBySlug($product);
}