<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswers;
use Livewire\Component;

class FormStep6 extends Component
{
    public PostForm $form;

    public int $originCountry;
    public string $newCountry = "";

    public $stepId;

    public $jsonQuestion;

    protected $rules = [
        'originCountry' => 'required',
    ];

    protected $messages = [
        'originCountry.required' => 'Herkomstland is verplicht',
    ];

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
            $this->form->createAnswer([$this->originCountry], $this->jsonQuestion, $this->stepId);

            if(!empty($this->newCountry)){
                $this->jsonQuestion->question_title = $this->jsonQuestion->question_options->question_custom_input_title;
                $this->jsonQuestion->question_type = 'text';
                $this->form->createAnswer([$this->newCountry], $this->jsonQuestion, $this->stepId);
            }

            \Session::put(['student-origin-country' => $this->originCountry]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->originCountry = old('originCountry') ?? \Session::get('student-origin-country') ?? $this->jsonQuestion->question_options->question_answer_id;
    }

    public function render()
    {
        return view('livewire.forms.form-step6');
    }
}
