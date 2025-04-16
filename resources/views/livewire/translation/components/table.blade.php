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
    @include('livewire.translation.components.edit')
    <!-- Create Modal -->
    @include('livewire.translation.components.create')
    <!-- Delete Confirmation Modal -->

    <!-- View Modal -->
    @include('livewire.translation.components.view')

    <button data-bs-toggle="modal" data-bs-target="#createModal"
            class="btn btn-outline-success btn-outline-md mb-2">Create New Translation
    </button>

    <button
            wire:click="extract()"
            class="btn btn-outline-danger btn-md mb-2">Extract translations
    </button>

    <button
            wire:click="updateSeeder()"
            class="btn btn-outline-primary btn-md mb-2">Write to seeder
    </button>

    <button
            wire:click="importSeeder()"
            class="btn btn-outline-info btn-md mb-2">Import from seeder
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
                <option value="id">Surveyquestion_id</option>
                <option value="slug">Slug</option>
                <option value="en">en</option>
                <option value="nl">nl</option>
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
                <th>slug</th>
                <th>en</th>
                <th>nl</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($paginatedTranslations as $model)
                <tr>
                    <td>{{$model->id}}</td>
                    <td>{{$model->slug}}</td>
                    <td>{{$model->en}}</td>
                    <td>{{$model->nl}}</td>

                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#viewModal"
                                wire:click="initData({{ $model }})"
                                class="btn btn-outline-info btn-sm">View
                        </button>
                        <button data-bs-toggle="modal" data-bs-target="#editModal"
                                wire:click="initData({{ $model }})"
                                class="btn btn-outline-primary btn-sm">Edit
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No translations found...</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{$paginatedTranslations->links()}}
    </div>
</div>
