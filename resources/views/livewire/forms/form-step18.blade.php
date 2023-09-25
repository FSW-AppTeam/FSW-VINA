<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div id="scope-form-step18">

        <div class="container text-center">
            <h5 class="py-3">{{ $jsonQuestion->question_content }}</h5>
        </div>

        <div class="text-center mb-5">
            <div class="block-student-active ">
                <div id="{{$startStudent['id']}}"
                     class="p-3 btn-circle btn-xl" data-start-student>
                    {{$startStudent['name']}}
                </div>

                <div class="block-students-vertical">
                    @foreach($students as $student)
                        <div id="{{$student['id']}}"
                             class="p-3 btn-circle btn-xl fadeOut">
                            {{$student['name']}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="container-sm">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-10 col-lg-8">
                    @if(!empty($answerSelected))
                        <button type="button" data-start-square
                             wire:click="$dispatch('set-square-animation');"
                             id="{{$answerSelected['id']}}"
                             class="btn btn-outline-secondary press-buttons-inline rounded"
                             style="height: 50px; border: solid 2px orange;padding-top: 12px;">
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
                <div class="col-10 col-lg-8">
                    @foreach ($jsonQuestion->question_answer_options as $answer)
                        <livewire:partials.answer-btn-block :id="$answer->id" :value="ucfirst($answer->value)" :answer-selected="$answerSelected" wire:key="{{ $answer->id . now() }}" />
                    @endforeach
                </div>
            </div>
            </div>
        </div>
    </div>
</x-layouts.form>


