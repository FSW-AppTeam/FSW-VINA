<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div class="mt-4">
    @if($setPage)
        <div class="form-group set-fade-in">
            <h6 class="pb-3 pl-4">{{ $jsonQuestion->question_content }}</h6>

            <div class="form-group block-multi-question">
                <div class="col d-flex justify-content-center align-items-center row">
                    @foreach ($jsonQuestion->question_answer_options as $key => $answer)
                        <button class="form-check btn" type="button" wire:key="form-step-4-{{$key . time()}}"   wire:click="$dispatch('select-answer-block', {event: event});">
                            <input class="form-check-input" type="radio"  wire:key="form-step-4-{{$key . time()}}"   wire:model="gender" id="{{ $answer->id }}" value="{{ $answer->id }}"/>

                            <label class="form-check-label" for="{{ $answer->id }}">
                                {{ ucfirst($answer->value) }}
                            </label>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    </div>
</x-layouts.form>



