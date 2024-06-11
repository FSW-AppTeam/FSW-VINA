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
    @include('livewire.surveyanswers.components.edit')
    <!-- Edit Category Bulk Modal -->
    @include('livewire.surveyanswers.components.edit-bulk')
    <!-- Create Modal -->
    @include('livewire.surveyanswers.components.create')
    <!-- Delete Confirmation Modal -->
    @include('livewire.surveyanswers.components.delete')
    <!-- View Modal -->
    @include('livewire.surveyanswers.components.view')


    <button data-bs-toggle="modal" data-bs-target="#createModal"
            class="btn btn-outline-success btn-outline-md mb-2">Create New SurveyAnswers
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
                <option value="surveyanswers_id">Surveyanswers_id</option><option value="student_id">Student_id</option><option value="question_id">Question_id</option><option value="question_type">Question_type</option><option value="question_title">Question_title</option><option value="student_answer">Student_answer</option><option value="created_at">Created_at</option><option value="updated_at">Updated_at</option>
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
                <th>student_id</th><th>question_id</th><th>question_type</th><th>question_title</th><th>student_answer</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($paginatedSurveyAnswerss as $model)
                <tr>
                    <td>
                        <input wire:model.live="selectedSurveyAnswerss" id="{{$model->id}}" value="{{$model->id}}" type="checkbox">
                    </td>
                    <td>{{$model->student_id}}</td>
                    <td>{{$model->question_id}}</td>
                    <td>{{$model->question_type}}</td>
                    <td>{{$model->question_title}}</td>
                    <td>{{json_encode($model->student_answer)}}</td>
                    <td>
                        <a class="btn btn-outline-info btn-sm"
                           href="#" wire:click.stop.prevent="redirectToDetail('surveyanswersdetails', {{ $model->id }})" >
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
                    <td colspan="5" class="text-center">No surveyanswers found...</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{$paginatedSurveyAnswerss->links()}}
    </div>
</div>
