<?php

namespace App\Livewire;

use App\Models\Role;
use Livewire\Component;

class RoleDetails extends Component
{
    public ?Role $role = null;

    public function render()
    {
        return view('livewire.role.components.details', $this->role);
    }

    //Get & assign selected post props
    public function initData(Role $role)
    {
        // assign values to public props
        $this->role = $role;
        $this->role_id = $role->id;
        $this->name = $role->name;
        $this->created_at = $role->created_at;
        $this->updated_at = $role->updated_at;

        $this->selectedRole = [];
    }

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset(['selectedRoles', 'bulkDisabled',
            'role_id',
            'name',
            'created_at',
            'updated_at',
        ]);
    }
}
