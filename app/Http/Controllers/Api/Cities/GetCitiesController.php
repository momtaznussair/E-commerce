<?php

namespace App\Http\Controllers\Api\Cities;

use App\Traits\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CountryRepositoryInterface;

class GetCitiesController extends Controller
{
    use ApiResponse;
    public function __invoke($id, CountryRepositoryInterface $countryRepository) {
        return $this->apiResponse($countryRepository->getCities($id), 'List of all available cities');
    }
}
