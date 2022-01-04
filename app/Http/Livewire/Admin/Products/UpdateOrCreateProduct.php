<?php

namespace App\Http\Livewire\Admin\Products;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UpdateOrCreateProduct extends Component
{
    use AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['productSelected'];
    public $mode = 'create'; //create or 
    public $name, $description, $price, $product_id;
    
    public function render()
    {
        return view('livewire.admin.products.update-or-create-product');
    }

    public function productSelected($product){
        $this->mode = 'edit';
        $this->product_id = $product['id'];
        $this->name = $product['name'];
        $this->price = $product['price'];
        $this->description = $product['description'];
    }

    protected function rules() {
        return [ 
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|between:0,9999999999999.99',
            'description' => 'nullable|string'
        ];
    }

    public function create(ProductRepositoryInterface $ProductRepository) {
        $this->authorize('Product_create');
        $ProductRepository->add($this->validate()) && 
        $this->resetAll();
        $this->emit('productsUpdated');
        $this->emit('success', __('Created Successfully!'));
     }
 
     public function edit(ProductRepositoryInterface $ProductRepository)  {
         $this->authorize('Product_edit');
         $ProductRepository->update($this->product_id, $this->validate()) && 
         $this->emit('productsUpdated');
         $this->emit('success', __('Changes Saved!'));
         $this->resetAll();
    }

    public function resetAll() {
        $this->reset();
        $this->resetValidation();
    }
}
