<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class FormStepIntro extends Component
{
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
        $this->dispatch('step-up')->component(StepController::class);
    }

    public function render()
    {
        $this->loading = false;
        return view('livewire.forms.form-step-intro');
    }
}
