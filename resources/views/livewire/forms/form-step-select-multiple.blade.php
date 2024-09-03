<x-layouts.form :step-id="$stepId"
                :loading="$loading"
                :json-question="$jsonQuestion">
    <div id="scope-form-step15" class="set-fade-in">
        <div class="container text-center">
            <h6 class="pb-3 mt-4 text-center mx-4">{{ ucfirst(printWithQuestionOptions( $jsonQuestion->question_content, $questionOptions, 2)) }} </h6>
        </div>
        <livewire:partials.students-buttons
                wire:key="students-buttons-{{ time() }}"
                :students="$students"
                :subject="$subject"
                :bounceOut="$bounceOut"
                :showShrink="$showShrink"
        />
        <div class="container-sm">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-11 col-lg-8">
                    @if(!empty($answerSelected))
                        <button type="button" data-start-square
                             id="{{$answerSelected['id']}}"
                             class="btn press-buttons-inline rounded
                             @if($bounceOut) bounce-out-left-btn @endif"
                             style="height: 50px; border: solid 2px orange;padding-top: 10px;">
                            {{ ucfirst(printWithQuestionOptions( $answerSelected['value'], $questionOptions, 3)) }}
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
                                wire:key="form-step-q15-{{ $answer['id'] . time() }}" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.form>


