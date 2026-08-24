<x-layouts.form :step-id="$stepId"
                :loading="$loading"
                :json-question="$jsonQuestion">
    <div id="scope-form-step49" class="set-fade-in">
        <div class="container text-center">
            <h6 class="pb-3 mt-4 text-center mx-4">{!! ucfirst(printWithQuestionOptions( $jsonQuestion->question_content, $questionOptions, 2)) !!}</h6>
        </div>
        <livewire:partials.students-buttons
                wire:key="students-buttons-{{ time() }}"
                :students="$students"
                :subject="$subject"
                :showShrink="$showShrink"
        />

        <div class="container-sm">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-11 col-lg-8">
                    @if(!empty($answerSelected))
                        <button type="button"
                                data-start-square
                                id="{{$answerSelected['id']}}"
                                class="btn press-buttons-inline rounded"
                                wire:click="removeSelectedSquare({{$answerSelected['id']}})"
                                style="height: 50px; border: solid 2px orange;padding-top: 10px;">
                            {{ ucfirst(printWithQuestionOptions( $answerSelected['value'], $questionOptions, 3)) }}
                            @if(($answerSelected['id'] ?? null) === 5 && ! empty($otherCountry))
                                <b><i>{{ $otherCountry }}</i></b>
                            @endif
                        </button>
                    @else
                        <div id="set-square-area" class="btn btn-outline-secondary press-buttons-inline rounded"></div>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group mt-4 mb-1">
            <div class="container-sm">
                <div class="row justify-content-center align-items-center">
                    <div class="col-11 col-lg-8">
                        @foreach ($jsonQuestion->question_answer_options as $answer)
                            <livewire:partials.answer-btn-block
                                :id="$answer['id']"
                                :value="ucfirst(printWithQuestionOptions( $answer['value'], $questionOptions, 3))"
                                :questionOptions="$questionOptions"
                                :answer-selected="$answerSelected"
                                :disabled-btn="$disabledBtn"
                                wire:key="form-step49-{{ $answer['id'] . time() }}" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade"
         id="countryModal" tabindex="-1" role="dialog" aria-labelledby="countryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered rounded" role="document">
            <div class="modal-content" style="height: 22rem;">
                <div class="float-end">
                    <button type="button" class="float-end p-3 btn-close" data-bs-dismiss="modal"
                            aria-label="Sluit"></button>
                </div>
                <h5 class="modal-title text-center" id="countryModalLabel">Kies een land</h5>
                <div class="modal-body">
                    @livewire('components.search-dropdown', ['targetComponent' => 'forms.form-step49'])

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
