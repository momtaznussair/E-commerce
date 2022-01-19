<?php

namespace App\Http\Controllers\Api\Cities;

use App\Traits\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Repositories\Contracts\CountryRepositoryInterface;

class CitiesController extends Controller
{
    use ApiResponse;
    public function __invoke($id, CountryRepositoryInterface $countryRepository) {
        $cities = CityResource::collection($countryRepository->getCities($id));
        return $this->apiResponse($cities, 'List of all available cities');
    }
}
