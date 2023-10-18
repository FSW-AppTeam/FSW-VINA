<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div class="mt-4">
        @if($setPage)
            <div class="form-group set-fade-in">
                    <h6 class="pb-2">{{ $jsonQuestion->question_content }}</h6>
                    <input type="text" wire:model="classId" class="form-control style-input" name="student-class-code">
            </div>
        @endif
    </div>
</x-layouts.form>
