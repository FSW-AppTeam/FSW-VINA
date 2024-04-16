<x-layouts.form :step-id="$stepId"
                :next-enabled="$nextEnabled"
                :back-enabled="$backEnabled"
                :json-question="$jsonQuestion">
    <div id="scope-form-step21" class="set-fade-in">
        <div class="container py-3">
            <div class="row">
                <div class="col-sm-10">
                    <p class="">{{ $jsonQuestion->question_content }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.form>


