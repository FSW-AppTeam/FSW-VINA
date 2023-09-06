<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswers;
use Livewire\Component;

class FormStep9 extends Component
{
    public PostForm $form;

    public int $religion;
    public string $newReligion = "";

    public $stepId;

    public $jsonQuestion;

    protected $rules = [
        'religion' => 'required',
    ];

    protected $messages = [
        'religion.required' => 'Godsdienst is verplicht',
    ];

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
            $this->form->createAnswer([$this->religion], $this->jsonQuestion, $this->stepId);

            if(!empty($this->newReligion)){
                $this->jsonQuestion->question_title = $this->jsonQuestion->question_options->question_custom_input_title;
                $this->jsonQuestion->question_type = 'text';
                $this->form->createAnswer([$this->newReligion], $this->jsonQuestion, $this->stepId);
            }

            \Session::put(['student-religion' => $this->religion]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->religion = old('religion') ?? \Session::get('student-religion') ?? $this->jsonQuestion->question_options->question_answer_id;
    }

    public function render()
    {
        return view('livewire.forms.form-step9');
    }
}
