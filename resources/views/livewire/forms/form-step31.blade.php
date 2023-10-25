<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div id="scope-form-step31" class="set-fade-in">

        <div class="container mt-3">
            <h6>{{ $jsonQuestion->question_options->extra_text }}</h6>
            <h6>{{ $jsonQuestion->question_content }}</h6>

            <textarea id="answer-end" name="answer-end" rows="7" cols="41" class="mt-2" maxlength="2000" wire:model="answerText"></textarea>
        </div>
    </div>
</x-layouts.form>
