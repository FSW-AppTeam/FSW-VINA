<div class="">

    @if(isset($activeStep))
        @livewire($activeStep, key('step-controller-id-'.$stepId), [
                'jsonQuestion' => $jsonQuestion,
                'stepId' => $stepId,
                'nextEnabled' => $nextEnabled,
                'backEnabled' => $backEnabled,
                'jsonQuestionNameList' => $jsonQuestionNameList
    ])
    @endif
</div>
