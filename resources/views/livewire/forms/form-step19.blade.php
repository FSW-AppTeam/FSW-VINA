<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div id="scope-form-step19" class="layout-wrapper">
        <div class="container py-3">
            <div class="row">
                <div class="col-sm-10">
                    <p class="">{{ $jsonQuestion->question_content }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.form>


