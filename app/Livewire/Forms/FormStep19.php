<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class FormStep19 extends Component
{
    public PostForm $form;

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;
    public $savedAnswers;

    public function save(): void
    {
        $this->dispatch('set-step-id-up');
    }

    public function render()
    {
        return view('livewire.forms.form-step19');
    }
}
