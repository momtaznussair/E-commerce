<?php

namespace App\Http\Livewire\Admin\Categories;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class Categories extends Component
{
    use WithPagination, AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';
    public $name;
    public $trashed = false, $active = true, $search = '';
    public $category;
    
    public function render(CategoryRepositoryInterface $category)
    {
        $this->authorize('Category_access');
        return view('livewire.admin.categories.categories', [
            'categories' => $category->getAll($this->active, ['isTrashed' => $this->trashed,  'Search' => $this->search])
        ]);
    }

    protected function rules() {
        return [ 'name' => 'required|unique:categories,name'];
    }

    public function selectCategory($category) {
        $this->category = $category['id'];
        $this->name = $category['name'];
    }

    public function save(CategoryRepositoryInterface $categoryRepository) {
       $this->authorize('Category_create');
       $categoryRepository->add($this->validate()) && 
       $this->reset('name');
       $this->emit('success', __('Created Successfully!'));
    }

    public function update(CategoryRepositoryInterface $categoryRepository)  {
        $this->authorize('Category_edit');
        $validName = $this->validate([ 'name' => 'required|unique:categories,name,' . $this->category]);
        $categoryRepository->update($this->category, $validName) && 
        $this->emit('success', __('Changes Saved!'));
        $this->reset('name');
    }

    public function delete(CategoryRepositoryInterface $categoryRepository) {
        $this->authorize('Category_delete');
        $categoryRepository->remove($this->category) &&
        $this->emit('success', __('Deleted successfully!'));
        $this->reset('name');
    }

    public function toggleActive(Bool $active, CategoryRepositoryInterface $categoryRepository) {
        $this->authorize('Category_edit');
       $categoryRepository->toggleActive($this->category, $active) && 
       $this->emit('success', __('Changes Saved!'));
    }

    public function restore($category, CategoryRepositoryInterface $categoryRepository) {
        $this->authorize('Category_delete');
        $categoryRepository->restore($category) &&
        $this->emit('success', __('Item restored!'));
    }

    public function forceDelete(CategoryRepositoryInterface $categoryRepository) {
        $this->authorize('Category_delete');
        $categoryRepository->forceDelete($this->category) &&
        $this->emit('success', __('Deleted successfully!'));
        $this->reset('name');
    }
}
