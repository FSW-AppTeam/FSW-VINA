<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="createModal" tabindex="-1" role="dialog"
     aria-labelledby="createSurvey" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Survey</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="store">
                    
            <div class="form-group">
                <label for="survey_code">Survey survey_code:</label>
                <input wire:model="survey_code" type="text" class="form-control" name="survey_code"
                       id="survey_code"
                       title="Survey survey_code" placeholder="Enter survey survey_code..." autofocus>
                @error("survey_code")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click.prevent="clearFields" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="store" type="submit" class="btn btn-outline-primary">Submit
                </button>
            </div>
        </div>
    </div>
</div>
