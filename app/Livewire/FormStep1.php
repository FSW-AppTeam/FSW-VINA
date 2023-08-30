<?php

namespace App\Livewire;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Rule;
use Livewire\Component;

class FormStep1 extends Component
{
    public $classId = '';

    public $inputData;

    #[Locked]
    public $lockedId;

    public $jsonQuestion;

    public $stepId;

    protected $listeners = ['save'];

    protected $rules = [
        'classId' => 'required|min:2',
    ];

    protected $messages = [
        'classId.required' => 'De klas code is verplicht.',
        'classId.min' => 'De :attribute is minimaal 2 karakters.',
    ];

    public function mount(): void
    {
        $this->classId = old('classId') ?? \Session::get('step1-student-class-code') ?? "";
    }

    public function save(): void
    {
       $this->validate();

        \Session::put([
            'step1-student-class-code' => $this->classId,
            'step1' => true
        ]);

        $this->dispatch('setStepIdUp');

//        $this->reset('title', 'body');
    }

    public function update()
    {
        session()->flash('message', 'UPDATED!!!');
    }

    public function render()
    {
        return view('livewire.form-step1');
    }
}
