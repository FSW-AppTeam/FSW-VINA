<?php

namespace App\Livewire\Forms;

use App\Livewire\Partials\AnswerBtnBlock;
use App\Livewire\Partials\FlagImage;
use Closure;
use Livewire\Component;

class FormStep26 extends Component
{
    public PostForm $form;

    public $stepId;

    public $jsonQuestion;

    public $answerText = "";

    public function setAnswer(string $val): void
    {
        $this->answerText = $val;
    }

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
            $this->form->createAnswer([$this->answerText], $this->jsonQuestion, $this->stepId);

            \Session::put(['end-survey-answer' => $this->answerText]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->answerText = old('answerText') ?? \Session::get('end-survey-answer') ?? [];
    }

    public function render()
    {
        return view('livewire.forms.form-step26');
    }
}
