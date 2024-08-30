<div class="">
    @bladedebug('StepID: ' .  $stepId . ' -  questionid: ' . $jsonQuestion->id. ' - order: ' . $jsonQuestion->order . '- Form_type: ' . $jsonQuestion->form_type)
    @bladedebug('StudentName: ' . Session::get('student-name') . ' - ' . 'StudentID: ' . Session::get('student-id') . ' - ' . 'SurveyID: ' . Session::get('survey-id'))
    @bladedebug('<a class="skip-link" wire:click="continue()" >Continue</a>')
    @if(isset($activeStep))
        @livewire($activeStep, key('step-controller-id-'.$stepId), [
                'jsonQuestion' => $jsonQuestion,
                'questionOptions' => $questionOptions,
                'savedAnswers' => $savedAnswers,
                'stepId' => $stepId,
                'nextEnabled' => $nextEnabled,
                'backEnabled' => $backEnabled
    ])
    @endif
</div>
