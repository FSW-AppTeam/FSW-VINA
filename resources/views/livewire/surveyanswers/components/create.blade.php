<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="createModal" tabindex="-1" role="dialog"
     aria-labelledby="createSurveyAnswers" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New SurveyAnswers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="store">

            <div class="form-group">
                <label for="student_id">Student student_id:</label>
                <select  class="form-select" aria-label="Default select example" wire:model.live="student_id" id="student_id">
                    <option value="">-- Select --</option>
                    @foreach( App\Models\SurveyStudent::all()->pluck("name", "id") as $key=>$option)
                        <option value="{{$key}}" >{{$option}}</option>
                    @endforeach
                </select>
                @error("student_id")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="question_id">Question question_id:</label>
                <select  class="form-select" aria-label="Default select example" wire:model.live="question_id" id="question_id">
                    <option value="">-- Select --</option>
                    @foreach( App\Models\SurveyQuestion::all()->pluck("name", "id") as $key=>$option)
                        <option value="{{$key}}" >{{$option}}</option>
                    @endforeach
                </select>
                @error("question_id")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="question_type">Surveyanswers question_type:</label>
                <input wire:model="question_type" type="text" class="form-control" name="question_type"
                       id="question_type"
                       title="Surveyanswers question_type" placeholder="Enter surveyanswers question_type..." autofocus>
                @error("question_type")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="question_title">Surveyanswers question_title:</label>
                <input wire:model="question_title" type="text" class="form-control" name="question_title"
                       id="question_title"
                       title="Surveyanswers question_title" placeholder="Enter surveyanswers question_title..." autofocus>
                @error("question_title")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="student_answer">Surveyanswers student_answer:</label>
                <input wire:model="student_answer" type="text" class="form-control" name="student_answer"
                       id="student_answer"
                       title="Surveyanswers student_answer" placeholder="Enter surveyanswers student_answer..." autofocus>
                @error("student_answer")
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
