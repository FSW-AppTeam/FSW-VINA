<x-layouts.form :step-id="$stepId"
                :next-enabled="$nextEnabled"
                :back-enabled="$backEnabled"
                :json-question="$jsonQuestion">
    <div id="scope-form-step20" class="set-fade-in">

        @if(empty($startStudent))
            <div class="step-notification alert alert-danger text-center">
                <p>{{ $jsonQuestion->question_options['extra_text'] }}</p>
            </div>
        @else

            <div class="container text-center">
                <h6 class="pt-2 px-2">{{ $jsonQuestion->question_content }}</h6>
            </div>

            <div class="mt-4 text-center block-students-vertical line-students step-list-15 " data-student-list>
                @foreach($shadowStudents as $key => $student)
                    <div class="student-shadow-flex @if($key !== 0) fadeOut @endif">
                        <div id="{{$student['id']}}"
                             class="p-2 btn-circle btn-xl studentBtn title">
                            {{$student['name']}}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="container-sm">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-11 col-lg-8">
                    @if(!empty($answerSelected))
                        <button type="button" data-start-square
                             wire:click="$dispatchset-square-animation', {event:event});"
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

        <div class="form-group mt-3">
            <div class="container-sm">
            <div class="row justify-content-center align-items-center">
                <div class="col-11 col-lg-8">
                    @foreach ($jsonQuestion->question_answer_options as $answer)
                        <livewire:partials.answer-btn-block :id="$answer['id']" :value="ucfirst($answer['value'])" :answer-selected="$answerSelected" wire:key="step-form-q22-{{ $answer['id'] . time()}}" />
                    @endforeach
                </div>
            </div>
            </div>
        </div>
    </div>
</x-layouts.form>


