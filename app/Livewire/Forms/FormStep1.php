<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Locked;
use Livewire\Component;

class FormStep1 extends Component
{
    public $classId = '';

    public $inputData;

    #[Locked]
    public $lockedId;

    public $jsonQuestion;

//    #[Reactive]
    public $stepId;

    protected $rules = [
        'classId' => 'required|min:2',
    ];

    protected $messages = [
        'classId.required' => 'De klas code is verplicht.',
        'classId.min' => 'De :attribute is minimaal 2 karakters.',
    ];

    public function mount(): void
    {
        $this->classId = old('classId') ?? \Session::get('survey-student-class-id') ?? "";

//        session()->flush();

        dump('form step 1 mounted!!');

        session()->flash('message', 'Form Step 1 mounted -- ' . $this->stepId);
    }

    public function save(): void
    {
       $this->validate();

        \Session::put([
            'survey-student-class-id' => $this->classId,
            'step1' => true
        ]);

        $this->dispatch('set-step-id-up');

//        $this->reset('title', 'body');
    }

    public function update()
    {
        $this->dispatch('getJsonQuestion', 1);
        session()->flash('message', 'UPDATED!!!');
    }

    public function render()
    {
        return view('livewire.forms.form-step1')
            ->layout('layouts.form');
    }
}
