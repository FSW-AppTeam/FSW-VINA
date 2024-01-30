<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class FormStep1 extends Component
{
    public PostForm $form;
    public $classId = '';

    public $jsonQuestion;
    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestionNameList;

    /**
     * @var bool for the back routing
     */
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
        $this->classId = old('classId') ?? session::get('survey-student-class-id') ?? "";

        if($this->classId) {
            $this->nextEnabled = true;
        }
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules);
        $this->validate($this->rules);

        session::put([
            'survey-student-class-id' => strtolower($this->classId),
            'step1' => true
        ]);

        $this->dispatch('set-step-id-up');
    }

    public function updatedClassId()
    {
        $this->form->addRulesFromOutside($this->rules);
        $this->validate($this->rules);
        $this->dispatch('set-enable-next');
    }

    public function update()
    {
        $this->dispatch('getJsonQuestion', 1);
    }

    public function render()
    {
        return view('livewire.forms.form-step1');
    }
}
