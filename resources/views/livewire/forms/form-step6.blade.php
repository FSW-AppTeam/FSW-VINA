<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    @if($setPage)
        <div class="form-group set-fade-in">
        <h6 class="pb-3 mt-4">{{ $jsonQuestion->question_content }}</h6>

            <div class="form-group block-multi-question col border-end d-flex justify-content-center align-items-center row">
                @foreach ($jsonQuestion->question_answer_options as $index => $answer)
                    <button class="form-check btn" type="button" wire:click="$dispatch('select-answer-block', {event: event});">
                        <input class="form-check-input" type="radio" wire:model="classTime" id="{{ $answer->id }}" value="{{ $answer->id }}" name="select-btn-block"/>

                        <label class="form-check-label" for="{{ $answer->id }}" >
                            {{ ucfirst($answer->value) }}
                        </label>
                    </button>
                @endforeach
            </div>
        </div>
    @endif
</x-layouts.form>


