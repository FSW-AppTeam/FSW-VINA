<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Survey</h5>
                <button type="button" class="btn-close" wire:click.prevent="clearFields" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="update">
                        
            <div class="form-group">
                <label for="survey_code">Survey survey_code:</label>
                <input wire:model="survey_code" type="text" class="form-control" name="survey_code"
                       id="survey_code"
                       title="Survey survey_code" placeholder="Enter survey survey_code..." autofocus>
                @error("survey_code")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
                    <input wire:model.live="survey_id" type="hidden" name="id">
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
