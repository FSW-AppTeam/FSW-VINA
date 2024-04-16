<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class FormStep31 extends Component
{
    public PostForm $form;

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;
    public $savedAnswers;

    public $answerText = "";

    protected $rules = [
        'answerText' => 'string',
    ];

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules);
        $this->validate($this->rules);

        $this->form->createAnswer(strip_tags($this->answerText), $this->jsonQuestion, $this->stepId);
        $this->form->setStudentFinishedSurvey();
        $this->dispatch('set-step-id-up');
    }

    public function mount(): void
    {
        $this->answerText = $this->savedAnswers ?? null;
    }

    public function render()
    {
        return view('livewire.forms.form-step31');
    }
}
