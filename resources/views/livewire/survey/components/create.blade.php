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
                        <label for="survey_code">Survey code:</label>
                        <input wire:model="survey_code" type="text" class="form-control" name="survey_code"
                               id="survey_code"
                               title="Survey code" placeholder="Enter survey code..." autofocus>
                        @error("survey_code")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <label for="qualtrics_name">Survey qualtrics name:</label>
                        <input wire:model="qualtrics_name" type="text" class="form-control" name="qualtrics_name"
                               id="qualtrics_name"
                               title="Survey qualtrics_name" placeholder="Enter qualtrics name..." autofocus>
                        @error("qualtrics_name")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <label for="qualtrics_id">Survey qualtrics_id:</label>
                        <input wire:model="qualtrics_id" type="text" class="form-control" name="qualtrics_id"
                               id="qualtrics_id"
                               title="Survey qualtrics_id" placeholder="Enter qualtrics id..." autofocus>
                        @error("qualtrics_id")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <label for="qualtrics_param">Survey qualtrics_param:</label>
                        <input wire:model="qualtrics_param" type="text" class="form-control" name="qualtrics_param"
                               id="qualtrics_param"
                               title="Survey qualtrics_param" placeholder="Enter name of params to pass through qualtrics..." autofocus>
                        @error("qualtrics_param")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <label for="participant_source">Participant source:</label>
                        <select wire:model="participant_source" class="form-select" name="participant_source" id="participant_source">
                            <option value="">Default</option>
                            <option value="friends">Friends</option>
                        </select>
                        @error("participant_source")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="clearFields" data-bs-dismiss="modal">Close</button>
                        <button wire:click.prevent="store" type="submit" class="btn btn-outline-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
