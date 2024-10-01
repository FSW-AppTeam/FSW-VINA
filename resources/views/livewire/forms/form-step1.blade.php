<x-layouts.form :step-id="$stepId"
                :loading="$loading"
                :json-question="$jsonQuestion">
    <div class="mt-4">
        <div class="form-group set-fade-in">
                <h6 class="pb-2">{{ $jsonQuestion->question_content }}</h6>
                <input type="text"
                       id="surveyCode"
                       wire:model="surveyCode"
                       class="form-control style-input" name="student-class-code">
        </div>
    </div>
</x-layouts.form>
