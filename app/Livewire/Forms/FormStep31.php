<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class FormStep31 extends Component
{
    public PostForm $form;

    public $stepId;

    public $nextEnabled;

    public $backEnabled;

    public $jsonQuestion;

    public $savedAnswers;

    public $answerText = '';

    protected $rules = [
        'answerText' => 'nullable|string|max:500',
    ];

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules);
        $this->validate($this->rules);

        $this->form->createAnswer(strip_tags($this->answerText), $this->jsonQuestion, $this->stepId);
        $this->form->setStudentFinishedSurvey();
    }

    public function mount(): void
    {
        $this->answerText = $this->savedAnswers ?? null;
    }

    public function render()
    {
        if ($this->form->getStudent()->finished_at) {
            return view('livewire.forms.form-step-outro');
        }

        return view('livewire.forms.form-step31');
    }
}
