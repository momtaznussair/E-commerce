<?php

namespace App\Http\Livewire\Admin\Admins;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Admins extends Component
{
    use WithPagination, AuthorizesRequests, WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $trashed = false, $active = true, $search = '';
    public $name, $admin_id;

    protected $listeners = ['adminsUpdated' => '$refresh'];

    public function render(AdminRepositoryInterface $adminRepository)
    {
        $this->authorize('Admin_access');
        return view('livewire.admin.admins.admins', [
            'admins' => $adminRepository->getAll($this->active, ['isTrashed' => $this->trashed,  'Search' => $this->search]),
        ]);
    }

    public function updatingSearch() {
        $this->resetPage();
    }

    public function select($admin, $toUpdate = false) {
        //if it's the edit button that was pressed we just send the selected Admin to the updateOrCreate Component
        if($toUpdate){ return $this->emit('adminSelected', ['admin' => $admin]); }
        $this->admin_id = $admin['id'];
        $this->name = $admin['name'];
    }

    public function delete(AdminRepositoryInterface $adminRepository) {
        $this->authorize('Admin_delete');
        $adminRepository->remove($this->admin_id) && 
        $this->emit('success', __('Deleted successfully!'));
    }

    public function restore($admin, AdminRepositoryInterface $adminRepository) {
        $this->authorize('Admin_delete');
        $adminRepository->restore($admin['id']) &&
        $this->emit('success', __('Item restored!'));
    }

    public function toggleActive(Bool $active, AdminRepositoryInterface $adminRepository) {
       $this->authorize('Admin_edit');
       $adminRepository->toggleActive($this->admin_id, $active) && 
       $this->emit('success', __('Changes Saved!'));
    }
    
    public function forceDelete(AdminRepositoryInterface $adminRepository) {
        $this->authorize('Admin_delete');
        $adminRepository->forceDelete($this->admin_id) &&
        $this->emit('success', __('Deleted successfully!'));
    }

}
