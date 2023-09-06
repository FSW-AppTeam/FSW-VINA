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
        'name.required' => 'Naam is verplicht',
        'name.min' => 'Je naam is minimaal 2 karakters.',
    ];

    public function save(): void
    {
        $this->validate();
//        $this->reset('name', 'title');

        if (\Session::has('survey-student-class-id')) {
            $this->form->createStudent(1, $this->name, \Session::get('survey-student-class-id'));
            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->name = old('student-name') ?? \Session::get('student-name') ?? "";

        dump('form step 2 mounted!!');

        session()->flash('message', 'Form Step 2 mounted -- ' . $this->stepId);
    }

    public function render()
    {
        return view('livewire.forms.form-step2');
    }
}
