<div class="">
{{--    {{ $activeStep }}--}}
{{--    {{ $stepId }}--}}

{{--    @php--}}
{{--        dump(json_encode($jsonQuestion));--}}
{{--         dump(Session::all());--}}
{{--    @endphp--}}

    @if(isset($activeStep))
        @livewire($activeStep, key('step-controller-id-'.$stepId), [
                'jsonQuestion' => $jsonQuestion,
                'stepId' => $stepId,
                'jsonQuestionNameList' => $jsonQuestionNameList
    ])
    @endif
</div>
