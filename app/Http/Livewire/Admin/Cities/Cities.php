<?php

namespace App\Http\Livewire\Admin\Cities;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Contracts\CityRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Repositories\Contracts\CountryRepositoryInterface;
use PragmaRX\Countries\Package\Countries as CountriesRepository;

class Cities extends Component
{
    use WithPagination, AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';
    public $search = '', $trashed = false, $active = true;
    public $name, $country_id, $allCitiesOfSelectedCountry = [], $countries = [];
    public $city;
    
    public function render(CityRepositoryInterface $cityRepository, CountryRepositoryInterface $countryRepository)
    {
        $this->countries =  $countryRepository->getAll()->pluck('name', 'id');
        return view('livewire.admin.cities.cities', [
            'cities' => $cityRepository
            ->getAll($this->active, ['isTrashed' => $this->trashed,  'Search' => $this->search]),
        ]);
    }

    public function rules() {
       return [
           'name' => 'required|string|max:255|unique:cities,name',
           'country_id' => 'required|exists:countries,id'
       ];
    }


    public function getCities() {
        if(!$this->country_id){  return; }  //clearing the select field "Changing it to null" will cause an error
        return CountriesRepository::where('name.common', $this->countries[$this->country_id])
        ->first()
        ->hydrateStates()
        ->states
        ->sortBy('name.common')
        ->pluck('name')->toArray();
    }

    public function select($city) {
       $this->resetValidation();
       $this->city = $city['id'];
       $this->name = $city['name'];
    }

    public function save(CityRepositoryInterface $cityRepository) {
        $this->authorize('City_create');
        $cityRepository->add($this->validate()) && 
        $this->emit('success', __('Created Successfully!'));
        $this->emit('reset-add-form');
        $this->reset();
    }

    public function toggleActive(Bool $active, CityRepositoryInterface $cityRepository) {
       $this->authorize('Course_edit');
        $cityRepository->toggleActive($this->city, $active) && 
        $this->emit('success', __('Changes Saved!'));
    }

    public function updatingSearch() {
        $this->resetPage();
    }

    public function delete(CityRepositoryInterface $cityRepository) {
        $this->authorize('Course_delete');
        $cityRepository->remove($this->city) &&
        $this->emit('success', __('Deleted successfully!'));
    }

    public function restore($city, CityRepositoryInterface $cityRepository) {
        $this->authorize('Course_delete');
        $cityRepository->restore($city) &&
        $this->emit('success', __('Item restored!'));
    }

    public function forceDelete(CityRepositoryInterface $cityRepository) {
        $this->authorize('Course_delete');
        $cityRepository->forceDelete($this->city) &&
        $this->emit('success', __('Deleted successfully!'));
        $this->reset('name');
    }
}
