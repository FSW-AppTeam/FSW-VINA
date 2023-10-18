<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div id="scope-form-step26">

        <div class="container mt-3">
            <h6 class="">{{ $jsonQuestion->question_options->extra_text }}</h6>
            <h6 class="">{{ $jsonQuestion->question_content }}</h6>

            <textarea id="answer-end" name="answer-end" rows="7" cols="35" class="mt-1" maxlength="1000"></textarea>
        </div>
    </div>
</x-layouts.form>


