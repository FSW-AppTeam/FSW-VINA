<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class FormStepIntro extends Component
{
    public $stepId;

    public $nextEnabled;

    public $backEnabled;

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
        $this->dispatch('step-up')->component(StepController::class);
    }

    public function render()
    {
        return view('livewire.forms.form-step-intro');
    }
}
