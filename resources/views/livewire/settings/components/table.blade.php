<div class="h-100">
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    @include('layouts.overlay')

    <!-- Edit Modal -->
    @include('livewire.settings.components.edit')
    <!-- Create Modal -->
    @include('livewire.settings.components.create')
    <!-- Delete Confirmation Modal -->
    @include('livewire.settings.components.delete')
    <!-- View Modal -->
    @include('livewire.settings.components.view')

    <button data-bs-toggle="modal" data-bs-target="#createModal"
            class="btn btn-outline-success btn-outline-md mb-2">Create New Setting
    </button>

    <div class="row">
        <div class="col-md-3">
            <label for="search">Search: </label>
            <input wire:model.live="query" id="search" type="text" placeholder="Search..." class="form-control">
            <p class="badge badge-info" wire:model.live="resultCount">{{$resultCount}}</p>
        </div>
        <div class="col-md-3">
            <label for="orderBy">Order By: </label>
            <select wire:model.live="orderBy" id="orderBy" class="form-select">
                <option value="id">Settings_id</option>
                <option value="key">Key</option>
                <option value="value">Value</option>
                <option value="created_at">Created_at</option>
                <option value="updated_at">Updated_at</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="direction">Order direction: </label>
            <select wire:model.live="orderAsc" id="direction" class="form-select">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="perPage">Items Per Page: </label>
            <select wire:model.live="perPage" id="perPage" class="form-select">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>
    </div>

    <td class="table-responsive">
        <table class="table table-hover table-sm">
            <thead>
            <tr>
                <th>id</th>
                <th>key</th>
                <th>value</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($paginatedSettings as $model)
                <tr>
                    <td>{{$model->id}}</td>
                    <td>{{$model->key}}</td>
                    <td>{{$model->value}}</td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#viewModal"
                                wire:click="initData({{ $model }})"
                                class="btn btn-outline-info btn-sm">View
                        </button>
                        <button data-bs-toggle="modal" data-bs-target="#editModal"
                                wire:click="initData({{ $model }})"
                                class="btn btn-outline-primary btn-sm">Edit
                        </button>
                        <button data-bs-toggle="modal" data-bs-target="#deleteModal"
                                wire:click="initData({{ $model }})"
                                class="btn btn-outline-danger btn-sm">Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No settings found...</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{$paginatedSettings->links()}}
    </div>
</div>
