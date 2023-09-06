<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    <div class="form-group">
        <label for="student-class-code" class="pb-1">{{ $jsonQuestion->question_content }}
        <input type="text" wire:model="classId" class="form-control" name="student-class-code">
        </label>
    </div>

    @error('student-class-code')
    <span class="mt-2 text-sm text-red-600">{{ $message }}</span>
    @enderror

</x-layouts.form>
