<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserDetails extends Component
{
    public ?User $user = null;

    public function render()
    {
        return view('livewire.user.components.details', $this->user);
    }

    //Get & assign selected post props
    public function initData(User $user)
    {
        // assign values to public props
        $this->user = $user;
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->role_id = $user->role_id;
        $this->email = $user->email;
        $this->email_verified_at = $user->email_verified_at;
        $this->created_at = $user->created_at;
        $this->updated_at = $user->updated_at;
        $this->solis_id = $user->solis_id;
        $this->allowed_attributes = $user->allowed_attributes;

        $this->selectedUser = [];
    }

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset(['selectedUsers', 'bulkDisabled',
            'user_id',
            'name',
            'role_id',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at',
            'solis_id',
            'allowed_attributes',
        ]);
    }
}
