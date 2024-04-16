<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit SurveyQuestion</h5>
                <button type="button" class="btn-close" wire:click.prevent="clearFields" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="update">
                        
            <div class="form-group">
                <label for="order">Surveyquestion order:</label>
                <input wire:model="order" type="text" class="form-control" name="order"
                       id="order"
                       title="Surveyquestion order" placeholder="Enter surveyquestion order..." autofocus>
                @error("order")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="question_type">Surveyquestion question_type:</label>
                <input wire:model="question_type" type="text" class="form-control" name="question_type"
                       id="question_type"
                       title="Surveyquestion question_type" placeholder="Enter surveyquestion question_type..." autofocus>
                @error("question_type")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="question_title">Surveyquestion question_title:</label>
                <input wire:model="question_title" type="text" class="form-control" name="question_title"
                       id="question_title"
                       title="Surveyquestion question_title" placeholder="Enter surveyquestion question_title..." autofocus>
                @error("question_title")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="question_content">Surveyquestion question_content:</label>
                <input wire:model="question_content" type="text" class="form-control" name="question_content"
                       id="question_content"
                       title="Surveyquestion question_content" placeholder="Enter surveyquestion question_content..." autofocus>
                @error("question_content")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="question_answer_options">Surveyquestion question_answer_options:</label>
                <input wire:model="question_answer_options" type="text" class="form-control" name="question_answer_options"
                       id="question_answer_options"
                       title="Surveyquestion question_answer_options" placeholder="Enter surveyquestion question_answer_options..." autofocus>
                @error("question_answer_options")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="question_options">Surveyquestion question_options:</label>
                <input wire:model="question_options" type="text" class="form-control" name="question_options"
                       id="question_options"
                       title="Surveyquestion question_options" placeholder="Enter surveyquestion question_options..." autofocus>
                @error("question_options")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
                    <input wire:model.live="surveyquestion_id" type="hidden" name="id">
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
