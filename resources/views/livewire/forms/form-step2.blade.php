<x-layouts.form :step-id="$stepId"
                :loading="$loading"
                :json-question="$jsonQuestion">
    <div class="mt-4">
        <div class="form-group set-fade-in">
                <h6 class="pb-2">{{ $jsonQuestion->question_content }}</h6>
                <input type="text" wire:model="name" class="form-control style-input"
                       id="student-name" name="student-name">

            <p class="mt-3 sub-head-text">
                {{langDatabase('form.step_two')}}
            </p>

            <p class="mt-3 sub-head-text">
                {{langDatabase('form.step_two_note')}}
            </p>
        </div>
    </div>
</x-layouts.form>




