<?php

namespace App\Http\Livewire\Admin\Admins;

use App\Models\Admin;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rules\Password;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class UpdateOrCreateAdmin extends Component
{
    use WithFileUploads,  AuthorizesRequests;

    public $avatar, $password, $password_confirmation, $roles, $mode = 'create';
    public Admin $admin;

    protected $listeners = ['adminSelected'];
    
    public function render(RoleRepositoryInterface $roleRepository) {
        return view('livewire.admin.admins.update-or-create-admin', [
            'allRoles' => $roleRepository->getAll()
            ->pluck('name', 'id')
        ]);
    }

    public function mount()
    {
      $this->admin = new Admin();
    }

    public function adminSelected(Admin $admin){
       $this->mode = 'edit';
       $this->admin = $admin;
       $this->roles = $admin->roles->pluck('id');
       $this->reset('avatar');
       $this->emit('changeRoles');
    }

    public function rules(){
        $rules =  [
            'admin.id' => 'nullable',
            'admin.name' => 'required|max:255|string',
            'admin.email' => 'required|email|max:255|unique:admins,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'admin.phone' => 'required|digits:11|numeric|unique:admins,phone',
            'avatar' =>  'nullable|image|max:1024', //1MB Max
            'roles' => 'required|array|exists:roles,id',
        ];

        if($this->mode == 'edit'){
            $rules['admin.email'] = 'required|email|max:255|unique:admins,email,' . $this->admin->id;
            $rules['password'] = ['nullable', 'confirmed', Password::defaults()];
            $rules['admin.phone'] = 'required|digits:11|numeric|unique:admins,phone,' . $this->admin->id;
            $rules['roles'] = 'nullable|array|exists:roles,id';
        }

        return $rules;
    }

    /**
     * updat current selected admin or create a new one
     */
    public function submit(AdminRepositoryInterface $adminRepository) {
        $attributes = $this->validate();
        $this->password && $attributes['admin']['password'] = $this->password;
        if($this->avatar){
            $this->admin->avatar && Storage::delete($this->admin->avatar);
            $attributes['admin']['avatar'] = $this->avatar->store('admins');
        }

        $this->authorize('Admin_' . $this->mode); // ('Admin_create') or ('Admin_edit')
        $adminRepository->updateOrCreate($attributes);
        $this->emit('adminsUpdated');
        $this->emit('success', $this->successMessages()[$this->mode]);
        $this->resetAll();
    }

    public function resetAll(){
        $this->reset('roles', 'avatar', 'password', 'password_confirmation', 'mode');
        $this->resetValidation();
        $this->admin = new Admin();
    }

    private function successMessages() {
        return [
            'create' => __('Created Successfully!'),
            'edit' => __('Changes Saved!')
        ];
    }

    //remove current admin immage
    public function confirmDelete() {
        $this->emit('confirmDelete');
    }

    public function deleteImage(AdminRepositoryInterface $adminRepository){
        $avatar = $this->admin->avatar;
        $adminRepository->removeImage($this->admin->id) && 
        Storage::delete($avatar);
        $this->emit('deleted');
        $this->emit('adminsUpdated');
    }
}
