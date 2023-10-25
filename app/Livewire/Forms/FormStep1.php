<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Locked;
use Livewire\Component;

class FormStep1 extends Component
{
    public $classId = '';

    public $jsonQuestion;

    public $stepId;

    public $setPage = true;

    protected $rules = [
        'classId' => 'required|min:2',
    ];

    protected $messages = [
        'classId.required' => 'De klas code is verplicht.',
        'classId.min' => 'De :attribute moet minimaal 2 karakters zijn.',
    ];

    public function mount(): void
    {
        $this->classId = old('classId') ?? \Session::get('survey-student-class-id') ?? "";
    }

    public function save(): void
    {
       $this->validate();

        \Session::put([
            'survey-student-class-id' => strtolower($this->classId),
            'step1' => true
        ]);

        $this->dispatch('set-step-id-up');
    }

    public function update()
    {
        $this->dispatch('getJsonQuestion', 1);
//        session()->flash('message', 'UPDATED!!!');
    }

    public function render()
    {
        return view('livewire.forms.form-step1');
    }
}
