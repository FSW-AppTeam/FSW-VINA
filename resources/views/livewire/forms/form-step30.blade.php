<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    @if($setPage)
    <div id="scope-form-step30" class="set-fade-in">

        <div class="container text-center mt-3 mb-2">
            <h6 class="py-3">{{ $jsonQuestion->question_content }}</h6>
        </div>

        <div class="container-sm ">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-12 col-lg-10">
                    @if(!empty($answerSelected))
                        <button type="button" data-start-square
                                wire:click="$dispatch('set-square-animation', {event:event})"
                                id="{{$answerSelected['id']}}"
                                class="btn btn-outline-secondary press-buttons-inline rounded"
                                style="height: 50px; border: solid 2px orange;padding-top: 10px;">
                            {{$answerSelected['value']}}
                        </button>
                    @else
                        <div id="set-square-area" class="btn btn-outline-secondary press-buttons-inline rounded"></div>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group mt-5">
            <div class="container-sm">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-lg-10">
                        @foreach ($jsonQuestion->question_answer_options as $answer)
                            <livewire:partials.answer-btn-block :id="$answer->id" :value="ucfirst($answer->value)" :answer-selected="$answerSelected" wire:key="step-form-btn-{{ $answer->id . time()}}" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-layouts.form>
