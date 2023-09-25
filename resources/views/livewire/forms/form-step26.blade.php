<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div id="scope-form-step26">

        <div class="container text-center">
            <h5 class="py-3">{{ $jsonQuestion->question_content }}</h5>
            <h5 class="py-3">{{ $jsonQuestion->question_options->extra_text }}</h5>

            <textarea id="answer-end" name="answer-end" rows="5" cols="40" class="mt-5"></textarea>
        </div>
    </div>
</x-layouts.form>


