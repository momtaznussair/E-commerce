<?php

namespace App\Http\Livewire\Admin\Profile;

use Livewire\Component;

class Header extends Component
{
    protected $listeners = ['profileUpdated' => '$refresh', 'adminsUpdated' => '$refresh', ];

    public function render()
    {
        return view('livewire.admin.profile.header');
    }
}
