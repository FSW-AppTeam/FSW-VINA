<?php

namespace App\Livewire\Forms;

use App\Models\SurveyStudent;
use Livewire\Component;

class FormStepOutro extends Component
{
    public PostForm $form;

    public $stepId;

    public $loading = true;

    public $jsonQuestion;

    public $savedAnswers;

    public $qualtricsLink;

    public $qualtricsName;

    protected $listeners = [
        'save' => 'save',
    ];

    public function mount(): void
    {
        $survey = $this->form->getSurvey();
        $student = SurveyStudent::find($this->form->getStudent()->id);
        $this->qualtricsName = $survey->qualtrics_name;

        $this->qualtricsLink = 'https://survey.uu.nl/jfe/form/'.$survey->qualtrics_id.'?'.$survey->qualtrics_param.'='.$student->uuid;
    }

    public function save(): void
    {
        $this->dispatch('step-up')->component(StepController::class);
    }

    public function render()
    {
        $this->loading = false;

        return view('livewire.forms.form-step-outro');
    }

    public function setStudentFinishedSurvey(): void
    {
        SurveyStudent::where([
            'id' => $this->form->getStudent()->id,
        ])
            ->update([
                'finished_at' => now(),
            ]);
    }
}
