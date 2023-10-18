<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div id="scope-form-step3" class="mt-4">
            @if($setPage)
                <div class="form-group set-fade-in">
                    <h6 class="pb-2">{{ $jsonQuestion->question_content }}</h6>
                    <input type="number" wire:model="age" name="age" class="form-control style-input" value="{{ $age }}"/>
                </div>
            @endif
        </div>
</x-layouts.form>
