<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class FormStepDisplay extends Component
{
    public PostForm $form;

    public $stepId;

    public $loading = true;

    public $jsonQuestion;

    public $savedAnswers;

    protected $listeners = [
        'save' => 'save',
    ];

    public function save(): void
    {
        $this->form->createAnswer('Done', $this->jsonQuestion, $this->stepId);
        $this->dispatch('step-up')->component(StepController::class);
    }

    public function render()
    {
        $this->loading = false;
        return view('livewire.forms.form-step-display');
    }
}
