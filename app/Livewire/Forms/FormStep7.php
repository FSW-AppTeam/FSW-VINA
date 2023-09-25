<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class FormStep7 extends Component
{
    public PostForm $form;

    public int $classTime;

    public $stepId;

    public $jsonQuestion;

    protected $rules = [
        'classTime' => 'required',
    ];

    protected $messages = [
        'classTime.required' => 'Tijd in de klas is verplicht',
    ];

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
            $this->form->createAnswer([$this->classTime], $this->jsonQuestion, $this->stepId);

            \Session::put(['student-class-time' => $this->classTime]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->classTime = old('classTime') ?? \Session::get('student-class-time') ?? $this->jsonQuestion->question_options->question_answer_id;
    }

    public function render()
    {
        return view('livewire.forms.form-step7');
    }
}
