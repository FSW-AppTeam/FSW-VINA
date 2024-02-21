<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class FormStep2 extends Component
{
    public PostForm $form;

    public string $name = '';

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;
    public $jsonQuestionNameList;

    protected $rules = [
        'name' => 'required|min:1|alpha_num:ascii',
    ];

    protected $messages = [
        'name.required' => 'Voornaam is verplicht',
        'name.min' => 'Je naam moet minimaal 1 karakter zijn.',
        'name.alpha_num' => 'Je kunt alleen letters en cijfers invoeren.'
    ];
    public $setPage = true;

    public function updatedName()
    {
        $this->form->addRulesFromOutside($this->rules);
        $this->validate($this->rules);
        $this->dispatch('set-enable-next');
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules);
        $this->validate($this->rules);

        if (session::has('survey-id')) {
            $this->form->createStudent($this->name, strtolower(session::get('survey-id')));
            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->name = old('student-name') ?? session::get('student-name') ?? "";

        if($this->name) {
            $this->nextEnabled = true;
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step2');
    }
}
