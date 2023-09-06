<div>
    {{-- The whole world belongs to you. --}}

    <h1>steps here </h1>
    {{ $activeStep }}
    {{ $stepId }}

    @php
        dump(json_encode($jsonQuestion));
         dump(Session::all());
    @endphp

    @if(isset($activeStep))
        @livewire($activeStep, key($activeStep), ['jsonQuestion' => $jsonQuestion, 'stepId' => $stepId])
    @endif
</div>
