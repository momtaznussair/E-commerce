<?php

namespace App\Http\Controllers\Api\Countries;

use App\Traits\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Repositories\Contracts\CountryRepositoryInterface;

class CountriesController extends Controller
{
    use ApiResponse;
    public function __invoke(CountryRepositoryInterface $countryRepository) {
        $countries = CountryResource::collection($countryRepository->getAll());
        return $this->apiResponse($countries , 'List of all available countries');
    }
}
