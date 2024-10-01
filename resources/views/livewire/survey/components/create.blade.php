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
                        <label for="qualtrics_name">Survey qualtrics name:</label>
                        <input wire:model="qualtrics_name" type="text" class="form-control" name="qualtrics_name"
                               id="qualtrics_name"
                               title="Survey qualtrics_name" placeholder="Enter qualtrics name..." autofocus>
                        <label for="qualtrics_id">Survey qualtrics_id:</label>
                        <input wire:model="qualtrics_id" type="text" class="form-control" name="qualtrics_id"
                               id="qualtrics_id"
                               title="Survey qualtrics_id" placeholder="Enter qualtrics id..." autofocus>
                        <label for="qualtrics_param">Survey qualtrics_param:</label>
                        <input wire:model="qualtrics_param" type="text" class="form-control" name="qualtrics_param"
                               id="qualtrics_param"
                               title="Survey qualtrics_param" placeholder="Enter name of params to pass through qualtrics..." autofocus>
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
