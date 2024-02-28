<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit SurveyStudent</h5>
                <button type="button" class="btn-close" wire:click.prevent="clearFields" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="update">

            <div class="form-group">
                <label for="name">Surveystudent name:</label>
                <input wire:model="name" type="text" class="form-control" name="name"
                       id="name"
                       title="Surveystudent name" placeholder="Enter surveystudent name..." autofocus>
                @error("name")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="survey_id">Survey survey_id:</label>
                <select  class="form-select" aria-label="Default select example" wire:model.live="survey_id" id="survey_id">
                    <option value="">-- Select --</option>
                    @foreach( App\Models\Survey::all()->pluck("survey_code", "id") as $key=>$option)
                        <option value="{{$key}}" >{{$option}}</option>
                    @endforeach
                </select>
                @error("survey_id")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
                    <input wire:model.live="surveystudent_id" type="hidden" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click.prevent="clearFields" data-bs-dismiss="modal">Close</button>
                <button type="submit" wire:click.prevent="update"
                        class="btn btn-outline-primary" data-bs-dismiss="modal">Update
                </button>
            </div>
        </div>
    </div>
</div>
