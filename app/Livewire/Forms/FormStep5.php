<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswers;
use Livewire\Component;

class FormStep5 extends Component
{
    public PostForm $form;

    public int $educationDegree;

    public $stepId;

    public $jsonQuestion;

    protected $rules = [
        'educationDegree' => 'required',
    ];

    protected $messages = [
        'educationDegree.required' => 'Opleidingsniveau is verplicht',
    ];

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
             $this->form->createAnswer([$this->educationDegree], $this->jsonQuestion, $this->stepId);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->educationDegree = old('education-degree') ?? \Session::get('student-education-degree') ?? $this->jsonQuestion->question_options->question_answer_id;
//        $this->educationDegree =  $this->jsonQuestion->question_options->question_answer_id;
    }

    public function render()
    {
        return view('livewire.forms.form-step5');
    }
}
