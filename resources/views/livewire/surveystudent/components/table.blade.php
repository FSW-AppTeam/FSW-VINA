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
    @include('livewire.surveystudent.components.edit')
    <!-- Edit Category Bulk Modal -->
    @include('livewire.surveystudent.components.edit-bulk')
    <!-- Create Modal -->
    @include('livewire.surveystudent.components.create')
    <!-- Delete Confirmation Modal -->
    @include('livewire.surveystudent.components.delete')
    <!-- View Modal -->
    @include('livewire.surveystudent.components.view')


    <button data-bs-toggle="modal" data-bs-target="#createModal"
            class="btn btn-outline-success btn-outline-md mb-2">Create New SurveyStudent
    </button>

    <button data-bs-toggle="modal" data-bs-target="#deleteModal"
            class="btn btn-outline-danger btn-md mb-2" {{ $bulkDisabled ? 'disabled' : null }}>Bulk Delete
    </button>

    <button wire:click.prevent="initDataBulk" data-bs-toggle="modal"
            data-bs-target="#editBulkModal"
            class="btn btn-outline-primary btn-md mb-2" {{ $bulkDisabled ? 'disabled' : null }}>Bulk Edit
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
                <option value="surveystudent_id">Surveystudent_id</option><option value="name">Name</option><option value="finished_at">Finished_at</option><option value="exported_at">Exported_at</option><option value="survey_id">Survey_id</option><option value="created_at">Created_at</option><option value="updated_at">Updated_at</option>
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

    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead>
            <tr>
                <th></th>
                <th>name</th>
                <th>uuid</th>
                <th>survey_id</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($paginatedSurveyStudents as $model)
                <tr>
                    <td>
                        <input wire:model.live="selectedSurveyStudents" id="{{$model->id}}" value="{{$model->id}}" type="checkbox">
                    </td>
                    <td class="col-md-3">{{$model->name}}</td>
                    <td class="col-md-4">{{$model->uuid}}</td>
                    <td class="col-md-2">{{$model->survey->survey_code}}</td>
                    <td class="col-md-3">
                        <a class="btn btn-outline-info btn-sm"
                           href="#" wire:click.stop.prevent="redirectToDetail('surveystudentdetails', {{ $model->id }})" >
                            Details
                        </a>
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
                    <td colspan="5" class="text-center">No surveystudent found...</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{$paginatedSurveyStudents->links()}}
    </div>
</div>
