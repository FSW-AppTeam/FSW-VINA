<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswers;
use Livewire\Component;

class FormStep4 extends Component
{
    public PostForm $form;

    public int $gender;

    public $stepId;

    public $jsonQuestion;

    protected $rules = [
        'gender' => 'required',
    ];

    protected $messages = [
        'gender.required' => 'Geslacht is verplicht',
    ];

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
             $this->form->createAnswer([$this->gender], $this->jsonQuestion, $this->stepId);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->gender = old('gender') ?? \Session::get('student-gender') ?? $this->jsonQuestion->question_options->question_answer_id;
    }

    public function render()
    {
        return view('livewire.forms.form-step4');
    }
}
