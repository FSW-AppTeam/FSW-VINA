<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div>
        <div for="question-title" class="pb-1 col-10 text-center">{{ $jsonQuestion->question_content }}</div>
        <div class="form-group">

            <div class="d-flex flex-row p-5">

                <div class="d-flex flex-row float-end students-balk" style="display: inline-block;">

                    <div class="col border-end d-flex justify-content-center align-items-center" style="display: inline-block">

                    @livewire('students')
                    </div>
                </div>

            </div>

            <div class="active-student p-2" id="active-student"></div>

            <div class="col border-end d-flex justify-content-center align-items-center row">
                @foreach ($jsonQuestion->question_answer_options as $index => $answer)
                    <button type="button" class="btn btn-secondary" style="width: 100%;margin: 10px"
                            id="{{ $index }}">{{ $answer->value }}</button>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.form>



