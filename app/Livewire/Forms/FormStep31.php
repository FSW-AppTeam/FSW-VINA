<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class FormStep31 extends Component
{
    public PostForm $form;

    public $stepId;

    public $jsonQuestion;

    public $answerText = "";

    protected $rules = [
        'answerText' => 'string',
    ];

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules);
        $this->validate($this->rules);

        if (session::has('survey-student-class-id')) {
            $this->form->createAnswer([strip_tags($this->answerText)], $this->jsonQuestion, $this->stepId);

            session::put(['student-end-survey-answer' => $this->answerText]);

            $this->form->setStudentFinishedSurvey();

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->answerText = old('answerText') ?? \Session::get('student-end-survey-answer') ?? "";
    }

    public function render()
    {
        return view('livewire.forms.form-step31');
    }
}
