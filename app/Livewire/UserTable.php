<?php

namespace App\Livewire;

use App\Models\User;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use AuthorizesRequests, WithPagination;

    //DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    public ?array $selected = [];

    //Create, Edit, Delete, View User props
    public ?string $name = null;

    public ?int $role_id = null;

    public ?string $email = null;

    public ?DateTime $email_verified_at = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?string $solis_id = null;

    public ?string $allowed_attributes = null;

    public ?int $user_id = null;

    public ?User $user = null;

    //Multiple Selection props
    public array $selectedUsers = [];

    public bool $bulkDisabled = true;

    //Update & Store Rules
    protected array $rules =
        [
            'name' => 'string',
            'role_id' => 'int',
            'email' => 'email',
            'solis_id' => 'string',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedUsers = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->paginate($this->perPage);
        //results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedUsers->count().' '.Str::plural('user', $paginatedUsers->count()).' found';

        return view('livewire.user.components.table', compact('paginatedUsers'));
    }

    //Toggle the $bulkDisabled on or off based on the count of selected posts
    public function updatedselectedUsers()
    {
        $this->bulkDisabled = count($this->selectedUsers) < 2;
        $this->user = null;
    }

    public function store()
    {
        $validatedData = $this->validate();
        \DB::transaction(function () use ($validatedData) {
            User::create($validatedData);
        });
        $this->refresh('User successfully created!');
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

    //Get & assign selected category
    public function initDataBulk()
    {

    }

    public function update()
    {
        $validatedData = $this->validate();
        $this->user->update($validatedData);
        $this->refresh('User successfully updated!');
    }

    //Bulk update
    public function updateBulk()
    {
        $this->validate();
        User::whereIn('id', $this->selectedUsers)->update([]);
        $this->refresh('User successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->selectedUsers)) {
            DB::transaction(function () {
                User::destroy($this->selectedUsers);
            });
        }

        if (! empty($this->user)) {
            DB::transaction(function () {
                $this->user->delete();
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

    /**
     * This method make more sense the model file.
     **/
    public function search($query)
    {
        $user = new User();

        return empty($query) ? $user :
            $user->where(function ($q) use ($query) {
                $q->where('name', 'like', '%'.$query.'%');
            });
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }
}
