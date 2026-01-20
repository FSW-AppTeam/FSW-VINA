<x-layouts.form :step-id="$stepId"
                :loading="$loading"
                :json-question="$jsonQuestion">
    <div class="form-group set-fade-in">
        <h6 class="pb-2 mt-1">{{ $jsonQuestion->question_content }}</h6>
        <p class="sub-head-text extra-text mt-2">{{ $jsonQuestion->question_options['extra_text'] }}</p>

        <div class="form-group block-multi-question col d-flex justify-content-center align-items-center row mt-2">
            @foreach ($jsonQuestion->question_answer_options as $index => $answer)
                <button class="form-check btn" type="button" wire:click="setAnswerBlockAnswerId({{$answer['id']}})">
                    <input class="form-check-input" type="radio" wire:model.live="originCountry"
                           name="select-btn-block"
                           id="{{ $answer['id'] }}"
                           value="{{ $answer['id'] }}"/>
                    <label class="form-check-label" for="{{ $answer['id'] }}">
                        {{ ucfirst($answer['value']) }}
                        @if($answer['id'] === 6 && !empty($otherCountry))
                            <b><i>{{ $otherCountry }}</i></b>
                        @endif
                    </label>
                </button>
            @endforeach
        </div>
    </div>

    <div wire:ignore.self class="modal fade"
         id="countryModal"  tabindex="-1" role="dialog" aria-labelledby="countryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered rounded" role="document">
            <div class="modal-content" style="height: 22rem;">
                <div class="float-end">
                    <button type="button" class="float-end p-3 btn-close " data-bs-dismiss="modal"
                            aria-label="Sluit"></button>
                </div>
                <h5 class="modal-title text-center" id="countryModalLabel">
                    {{langDatabase('form.step_seven_country_of_origin')}}
                </h5>
                <div class="modal-body">
                    @livewire('components.search-dropdown')

                    <div class="mt-1 p-2 text-center">
                        <button type="button" id="country-set-btn"
                                style="width:80%"
                            class="btn btn-outline-warning mt-5">OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.form>