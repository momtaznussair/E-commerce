<?php

namespace App\Http\Controllers\Api\Categories;

use App\Traits\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    use ApiResponse;

    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categories = CategoryResource::collection( $this->categoryRepository->getParents() )
        ->response()->getData(true);
        return $this->apiResponse($categories, 'List of categories');
    }

}
