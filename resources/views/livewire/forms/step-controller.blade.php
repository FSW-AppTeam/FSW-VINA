<div class="">
    @bladedebug('StepID: ' .  $stepId . ' - ' . 'questionid: ' . $jsonQuestion->id. ' - ' . 'order: ' . $jsonQuestion->order)
    @bladedebug('StudentName: ' . Session::get('student-name') . ' - ' . 'StudentID: ' . Session::get('student-id') . ' - ' . 'SurveyID: ' . Session::get('survey-id'))
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
