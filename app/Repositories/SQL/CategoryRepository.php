<?php

namespace App\Repositories\SQL;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository extends Repository implements CategoryRepositoryInterface{

    public function __construct(Category $category)
    {
       Parent::__construct($category);
    }

    /**
     * Display a listing of parent categories.
     *
     * @return 
     */
   public function getParents() {
      return $this->model->parents()
      ->isActive()
      ->with('children')
      ->get();
   }

   public function all() {
      return $this->model
      ->isActive()
      ->pluck('name', 'id')
      ->all();
   }
}