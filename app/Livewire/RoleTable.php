<?php

namespace App\Livewire;

use App\Models\Role;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class RoleTable extends Component
{
    use AuthorizesRequests, WithPagination;

    //DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    public ?array $selected = [];

    //Create, Edit, Delete, View Role props
    public ?string $name = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?int $role_id = null;

    public ?Role $role = null;

    //Multiple Selection props
    public array $selectedRoles = [];

    public bool $bulkDisabled = true;

    //Update & Store Rules
    protected array $rules =
        [
            'name' => 'string',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedRoles = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->paginate($this->perPage);
        //results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedRoles->count().' '.Str::plural('role', $paginatedRoles->count()).' found';

        return view('livewire.role.components.table', compact('paginatedRoles'));
    }

    //Toggle the $bulkDisabled on or off based on the count of selected posts
    public function updatedselectedRoles()
    {
        $this->bulkDisabled = count($this->selectedRoles) < 2;
        $this->role = null;
    }

    public function store()
    {
        $validatedData = $this->validate();
        \DB::transaction(function () use ($validatedData) {
            Role::create($validatedData);
        });
        $this->refresh('Role successfully created!');
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

    //Get & assign selected category
    public function initDataBulk()
    {

    }

    public function update()
    {
        $validatedData = $this->validate();
        $this->role->update($validatedData);
        $this->refresh('Role successfully updated!');
    }

    //Bulk update
    public function updateBulk()
    {
        $this->validate();
        Role::whereIn('id', $this->selectedRoles)->update([]);
        $this->refresh('Role successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->selectedRoles)) {
            DB::transaction(function () {
                Role::destroy($this->selectedRoles);
            });
        }

        if (! empty($this->role)) {
            DB::transaction(function () {
                $this->role->delete();
            });
        }
        $this->refresh('Successfully deleted!');
    }

    public function refresh($message)
    {
        session()->flash('message', $message);
        $this->clearFields();

        //Close the active modal
        $this->dispatch('hideModal');
    }

    public function mount()
    {

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

    /**
     * This method make more sense the model file.
     **/
    public function search($query)
    {
        $role = new Role();

        return empty($query) ? $role :
            $role->where(function ($q) use ($query) {
                $q->where('name', 'like', '%'.$query.'%');
            });
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }
}
