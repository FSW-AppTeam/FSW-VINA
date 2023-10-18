<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    @if($setPage)
        <div class="form-group set-fade-in">
            <h6 class="pb-3 mt-4">{{ $jsonQuestion->question_content }}</h6>
            <p class="sub-head-text extra-text mt-2">{{ $jsonQuestion->question_options->extra_text }}</p>

            <div class="form-group block-multi-question col d-flex justify-content-center align-items-center row mt-2">
                @foreach ($jsonQuestion->question_answer_options as $index => $answer)
                    <button class="form-check btn" type="button" wire:click="$dispatch('select-answer-block', {event: event});">
                        <input class="form-check-input" type="radio" wire:model="originCountry" id="{{ $answer->id }}" name="select-btn-block"
                               value="{{ $answer->id }}"/>

                        <label class="form-check-label" for="{{ $answer->id }}">
                            {{ ucfirst($answer->value) }}
                        </label>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="form-group mb-4">
            <input type="text" wire:model="fromCountry" class="form-control input-extra" name="fromCountry" />
        </div>
    @endif
</x-layouts.form>
