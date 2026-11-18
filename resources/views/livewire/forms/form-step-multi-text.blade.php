<x-layouts.form :step-id="$stepId"
                :loading="$loading"
                :json-question="$jsonQuestion">
    <div id="scope-form-step31" class="set-fade-in">

        <div class="container mt-3">
            <h6>{!! $jsonQuestion->question_content !!}</h6>
            @if(isset($jsonQuestion->question_options['extra_text']))
                <p class="sub-head-text ms-0">{!! $jsonQuestion->question_options['extra_text'] !!}</p>
            @endif
            @for ($i = 0; $i < $this->maxEntries; $i++)
                <div class="mb-2" data-multi-text-entry>
                    <label for="{{ $jsonQuestion->id }}-{{ $i + 1 }}" class="form-label">{{ $i + 1 }}</label>
                    <textarea id="{{ $jsonQuestion->id }}-{{ $i + 1 }}"
                              wire:model="input.{{ $i }}"
                              x-on:keydown.enter="if ($el.closest('[data-multi-text-entry]').nextElementSibling) { $event.preventDefault(); $el.closest('[data-multi-text-entry]').nextElementSibling.querySelector('textarea').focus() }"
                              class="form-control style-input"
                              name="{{ $jsonQuestion->question_content }}[{{ $i }}]"
                              rows="1"></textarea>
                </div>
            @endfor
        </div>
    </div>
</x-layouts.form>
