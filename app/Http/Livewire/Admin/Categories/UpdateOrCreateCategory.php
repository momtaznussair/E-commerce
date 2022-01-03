<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UpdateOrCreateCategory extends Component
{
    use AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['categorySelected'];
    public $mode = 'create'; //create or 
    public $name, $parent_id, $category;

    public function render(CategoryRepositoryInterface $categoryRepository)
    {
        return view('livewire.admin.categories.update-or-create-category', [
            'categories' => $categoryRepository->all()
        ]);
    }


    public function categorySelected($category){
        $this->mode = 'edit';
        $this->category = $category['id'];
        $this->name = $category['name'];
        $this->parent_id = $category['parent_id'];
    }

    protected function rules() {
        $rules =  [ 
            'name' => 'required|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id'
        ];

        if($this->mode = 'edit'){
            $rules['name'] = 'required|unique:categories,name,' . $this->category;
        }
        return $rules;
    }

    public function create(CategoryRepositoryInterface $categoryRepository) {
        $this->authorize('Category_create');
        $categoryRepository->add($this->validate()) && 
        $this->resetAll();
        $this->emit('categoriesUpdated');
        $this->emit('success', __('Created Successfully!'));
     }
 
     public function edit(CategoryRepositoryInterface $categoryRepository)  {
         $this->authorize('Category_edit');
         $categoryRepository->update($this->category, $this->validate()) && 
         $this->emit('categoriesUpdated');
         $this->emit('success', __('Changes Saved!'));
         $this->resetAll();
    }

    public function resetAll() {
        $this->reset();
        $this->resetValidation();
    }
}


