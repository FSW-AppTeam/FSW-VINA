<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class FormStepIntro extends Component
{
    public $stepId;

    public $jsonQuestion;

    public function mount(): void
    {
//        session()->flash('message', 'Form Step intro mounted');
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
