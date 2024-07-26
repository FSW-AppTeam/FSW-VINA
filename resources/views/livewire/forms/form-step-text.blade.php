<x-layouts.form :step-id="$stepId"
                :loading="$loading"
                :json-question="$jsonQuestion">
    <div id="scope-form-step31" class="set-fade-in">

        <div class="container mt-3">
            @if(isset($jsonQuestion->question_options['extra_text']))
                <h6>{{ $jsonQuestion->question_options['extra_text'] }}</h6>
            @endif
            <h6>{{ $jsonQuestion->question_content }}</h6>
            <input type="text"
                   id="{{$jsonQuestion->id}}"
                   wire:model.live.debounce="input"
                   class="form-control style-input" name="{{ $jsonQuestion->question_content }}">
        </div>
    </div>
</x-layouts.form>
