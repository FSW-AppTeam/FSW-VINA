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

    public function mount(): void
    {
    }

    public function save(): void
    {
        $this->dispatch('set-step-id-up');
    }

    public function render()
    {
        return view('livewire.forms.form-step-intro');
    }
}
