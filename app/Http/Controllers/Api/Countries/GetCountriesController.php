<?php

namespace App\Http\Controllers\Api\Countries;

use App\Traits\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CountryRepositoryInterface;

class GetCountriesController extends Controller
{
    use ApiResponse;
    public function __invoke(CountryRepositoryInterface $countryRepository) {
        return $this->apiResponse($countryRepository->getAll()->pluck('name', 'id'), 'List of all available countries');
    }
}
