<x-layouts.form :step-id="$stepId"
                :loading="$loading"
                :json-question="$jsonQuestion">
    <div id="scope-form-step17" class="set-fade-in">
        <div class="container py-3">
            <div class="row">
                <div class="col-sm-10">
                    <p class="">{{ $jsonQuestion->question_content }}</p>

                    <a href="{{ $qualtricsLink }}" class="btn btn-outline-primary">{{$qualtricsName}}</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.form>