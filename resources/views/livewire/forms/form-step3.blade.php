<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div class="form-group">
        <label for="age" class="pb-1">{{ $jsonQuestion->question_content }}
            <input type="text" wire:model="age" class="form-control" value="{{ $age }}"  />
        </label>
    </div>
</x-layouts.form>




