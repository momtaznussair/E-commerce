<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface extends RepositoryInterface{
    public function getParents();
    public function all();
}