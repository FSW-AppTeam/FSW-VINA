<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class FormStepIntro extends Component
{
    public PostForm $form;

    public $stepId;

    public $loading = true;

    public $jsonQuestion;

    public $savedAnswers;

    protected $listeners = [
        'save' => 'save',
    ];

    public function mount(): void
    {
    }

    public function save(): void
    {
        if (! session()->has('student-id') || ! session()->has('survey-id')) {
            $this->form->createAnonymousStudent();
        }

        $this->dispatch('step-up')->component(StepController::class);
    }

    public function render()
    {
        $this->loading = false;
        return view('livewire.forms.form-step-intro');
    }
}
