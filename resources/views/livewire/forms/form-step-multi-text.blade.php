<x-layouts.form :step-id="$stepId"
                :loading="$loading"
                :json-question="$jsonQuestion">
    <div id="scope-form-step31" class="set-fade-in">

        <div class="container mt-3">
            @if(isset($jsonQuestion->question_options['extra_text']))
                <h6>{{ $jsonQuestion->question_options['extra_text'] }}</h6>
            @endif
            <h6>{{ $jsonQuestion->question_content }}</h6>

            @for ($i = 0; $i < 20; $i++)
                <div class="mb-2">
                    <label for="{{ $jsonQuestion->id }}-{{ $i + 1 }}" class="form-label">{{ $i + 1 }}</label>
                    <textarea id="{{ $jsonQuestion->id }}-{{ $i + 1 }}"
                              wire:model.live.debounce="input.{{ $i }}"
                              class="form-control style-input"
                              name="{{ $jsonQuestion->question_content }}[{{ $i }}]"
                              rows="2"></textarea>
                </div>
            @endfor
        </div>
    </div>
</x-layouts.form>
