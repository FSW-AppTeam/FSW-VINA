<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div>
        <div for="question-title" class="pb-1 col-10 text-center">{{ $jsonQuestion->question_content }}</div>
        <div class="form-group">

            <div class="col border-end d-flex justify-content-center align-items-center row">
                @foreach ($jsonQuestion->question_answer_options as $index => $answer)
                    <div class="form-check" style="margin: 10px">
                        <input class="form-check-input" type="radio" wire:model="gender" id="{{ $answer->id }}" value="{{ $answer->id }}"  />

                        <label class="form-check-label" for="{{ $answer->id }}" >
                            {{ ucfirst($answer->value) }}
                        </label>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-layouts.form>



