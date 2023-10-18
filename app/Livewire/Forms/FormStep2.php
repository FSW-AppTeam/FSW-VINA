<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class FormStep2 extends Component
{
    public PostForm $form;

    public string $name = '';

    public $stepId;

    public $jsonQuestion;

    protected $rules = [
        'name' => 'required|min:2',
    ];

    protected $messages = [
        'name.required' => 'Voornaam is verplicht',
        'name.min' => 'Je naam moet minimaal 2 karakters zijn.',
    ];
    public $setPage = true;

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
            $this->form->createStudent(1, $this->name, \Session::get('survey-student-class-id'));
            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->name = old('student-name') ?? \Session::get('student-name') ?? "";

//        session()->flash('message', 'Form Step 2 mounted -- ' . $this->stepId);
    }

    public function render()
    {
        return view('livewire.forms.form-step2');
    }
}
