<?php

namespace App\Http\Controllers\Api\Products;

use Illuminate\Http\Request;
use App\Traits\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductIndexResource;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductController extends Controller
{
    use ApiResponse;

    private $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository) {
        $this->productRepository = $productRepository;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request) {
        $products = ProductIndexResource::collection( $this->productRepository->getAll(true, $request->all()) )
        ->response()->getData(true);
        return $this->apiResponse($products, 'List of Products');
    }

    public function show($product) {
        $product = new ProductResource($this->productRepository->getBySlug($product));
        return $this->apiResponse($product, 'Product Details');
    }
}
