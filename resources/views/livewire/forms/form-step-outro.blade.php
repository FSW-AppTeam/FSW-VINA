<x-layouts.form :step-id="$stepId"
                :loading="$loading"
                :json-question="$jsonQuestion">
    <div id="scope-form-step17" class="set-fade-in">
        <div class="container py-3">
            <div class="row">
                <div class="col-sm-10">
                    <p class="">{{ $jsonQuestion->question_content }}</p>
                    <a href="{{ $qualtricsLink }}" class="btn btn-secondary btn-end-survey float-end arrow"
                       wire:click="setStudentFinishedSurvey()"
                            id="nextButton">{{$qualtricsName}}
                        <svg xmlns="http://www.w3.org/2000/svg"  fill="black" class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.form>