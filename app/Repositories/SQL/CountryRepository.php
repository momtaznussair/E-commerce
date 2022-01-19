<?php

namespace App\Repositories\SQL;

use App\Models\Country;
use App\Repositories\Contracts\CountryRepositoryInterface;
class CountryRepository extends Repository implements CountryRepositoryInterface{

    public function __construct(Country $Country) {
       Parent::__construct($Country);
    }

    public function getCities($country_id){
       return $this->getById($country_id)
       ->cities()->get();
    }

}