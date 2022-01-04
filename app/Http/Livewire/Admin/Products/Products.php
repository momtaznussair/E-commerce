<?php

namespace App\Http\Livewire\Admin\Products;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Products extends Component
{
    use WithPagination, AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';
    public $name;
    public $trashed = false, $active = true, $search = '';
    public $product;

    protected $listeners = ['productsUpdated' => '$refresh'];

    public function render(ProductRepositoryInterface $productRepository)
    {
        $this->authorize('Product_access');

        return view('livewire.admin.products.products', [
            'products' => $productRepository->getAll($this->active, ['isTrashed' => $this->trashed,  'Search' => $this->search])
        ]);
    }


    public function select($product, $toUpdate = false) {
        //if it's the edit button that was pressed we just send the selected product to the updateOrCreate Component
        if($toUpdate){ return $this->emit('productSelected', $product); }
        $this->product = $product['id'];
        $this->name = $product['name'];
    }

    public function delete(ProductRepositoryInterface $productRepository) {
        $this->authorize('Product_delete');
        $productRepository->remove($this->product) &&
        $this->emit('success', __('Deleted successfully!'));
        $this->reset('name');
    }

    public function toggleActive(Bool $active, ProductRepositoryInterface $productRepository) {
        $this->authorize('Product_edit');
       $productRepository->toggleActive($this->product, $active) && 
       $this->emit('success', __('Changes Saved!'));
    }

    public function restore($product, ProductRepositoryInterface $productRepository) {
        $this->authorize('Product_delete');
        $productRepository->restore($product['id']) &&
        $this->emit('success', __('Item restored!'));
    }

    public function forceDelete(ProductRepositoryInterface $productRepository) {
        $this->authorize('Product_delete');
        $productRepository->forceDelete($this->product) &&
        $this->emit('success', __('Deleted successfully!'));
        $this->reset('name');
    }
}
