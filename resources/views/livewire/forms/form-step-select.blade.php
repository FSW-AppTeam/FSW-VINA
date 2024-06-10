<x-layouts.form :step-id="$stepId"
                :next-enabled="$nextEnabled"
                :back-enabled="$backEnabled"
                :json-question="$jsonQuestion">
    <div class="mt-4">
        <div class="form-group set-fade-in">
            <h6 class="pb-3 pl-4"> {{printWithQuestionOptions( $jsonQuestion['question_content'], $questionOptions, 2) }}</h6>
            <div class="form-group block-multi-question">
                <div class="col d-flex justify-content-center align-items-center row">
                    @foreach ($jsonQuestion->question_answer_options as $key => $answer)
                        <button class="form-check btn" type="button"
                                wire:key="form-step-{{$key . time()}}"
                                wire:click="$dispatch('select-answer-block', {event: event});">
                            <input class="form-check-input" type="radio"
                                   wire:key="form-step-{{$key . time()}}"
                                   wire:model.live="input" id="{{ $answer['id'] }}" value="{{ $answer['id'] }}"/>

                            <label class="form-check-label" for="{{ $answer['id'] }}">
                                {{ ucfirst(printWithQuestionOptions( $answer['value'], $questionOptions, 3)) }}
                            </label>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.form>



