<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class FormStep8 extends Component
{
    public PostForm $form;

    public int $indicationCountry;

    public $stepId;

    public $jsonQuestion;

    protected $rules = [
        'indicationCountry' => 'required',
    ];

    protected $messages = [
        'indicationCountry.required' => 'Tijd in de klas is verplicht',
    ];

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
            $this->form->createAnswer([$this->indicationCountry], $this->jsonQuestion, $this->stepId);

            \Session::put(['student-indication-country' => $this->indicationCountry]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->indicationCountry = old('indicationCountry') ?? \Session::get('student-indication-country') ?? $this->jsonQuestion->question_options->question_answer_id;
    }

    public function render()
    {
        return view('livewire.forms.form-step8');
    }
}
