<x-layouts.form :step-id="$stepId"
                :next-enabled="$nextEnabled"
                :back-enabled="$backEnabled"
                :json-question="$jsonQuestion">
    <div id="scope-form-step22" class="set-fade-in">
        @if(empty($shadowStudents) && empty($students))
            <div class="step-notification alert alert-danger text-center">
                <p>{{ $jsonQuestion->question_options['error_text'] }}</p>
            </div>
        @else
            <div class="container text-center">
                <h6 class="pt-4">{{ $jsonQuestion->question_content }}</h6>
            </div>

            <div class="text-center mb-2 wrapper-shadow-list">
                <div class="block-student-active shadow-row-step22"  >

                    <div class="block-students-vertical relation-block-student-shadow" data-student-list >
                        @foreach($shadowStudents as $key => $student)
                            <div class="justify-content-center text-center student-shadow-flex @if($key !== 0) fadeOut @endif" >
                                <div class="p-2 btn-circle btn-xl studentBtn title">
                                    <?= $student['id'] === $selfStudentId ? $selfText : $this->getStudentById($student['id'])['name']; ?>
                                </div>

                                <h2 class="circle-amp-student right">&#38;</h2>

                                <div class="p-2 btn-circle btn-xl studentBtn title">
                                        <?= $student['relation_id'] === $selfStudentId ? $selfText : $this->getStudentById($student['relation_id'])['name']; ?>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="container-sm">
                <div class="row justify-content-center align-items-center text-center">
                    <div class="col-12 col-lg-12">
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

            <div class="form-group mt-2">
                <div class="container-sm">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 col-lg-10">
                            @foreach ($jsonQuestion->question_answer_options as $answer)
                                <livewire:partials.answer-btn-block :id="$answer['id']" :value="ucfirst($answer['value'])"
                                                                    :answer-selected="$answerSelected"
                                                                    wire:key="{{ $answer['id'] . time() }}"/>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.form>


