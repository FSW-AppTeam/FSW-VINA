<x-layouts.form :step-id="$stepId"
                :next-enabled="$nextEnabled"
                :back-enabled="$backEnabled"
                :json-question="$jsonQuestion">
    <div id="scope-form-step16" class="set-fade-in">

        <div class="container text-center">
            <h6 class="mt-3 mb-2">{{ $jsonQuestion->question_content }}</h6>
        </div>

        <div class="container-sm mt-4">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-11 col-lg-8">
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

        <div class="form-group mt-3 mb-4">
            <div class="container-sm">
            <div class="row justify-content-center align-items-center">
                <div class="col-11 col-lg-8">
                    @foreach ($jsonQuestion->question_answer_options as $answer)
                        <livewire:partials.answer-btn-block :id="$answer['id']" :value="ucfirst($answer['value'])" :answer-selected="$answerSelected" wire:key="form-step-{{ $answer['id'] . time()}}" />
                    @endforeach
                </div>
            </div>
            </div>
        </div>
    </div>
</x-layouts.form>


