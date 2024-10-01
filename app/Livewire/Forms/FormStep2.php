<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Throwable;

class FormStep2 extends Component
{
    public PostForm $form;

    public string $name = '';

    public $stepId;

    public $loading = true;

    public $jsonQuestion;

    protected $listeners = [
        'save' => 'save',
    ];

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'min:1',
                'string',
                Rule::unique('survey_students')
                    ->where('survey_id', session::get('survey-id'))
                    ->ignore(session::get('student-id')),
            ],
        ];
    }

    protected $messages = [
        'name.required' => 'Voornaam is verplicht',
        'name.min' => 'Je naam moet minimaal 1 karakter zijn.',
        'name.alpha_num' => 'Je kunt alleen letters en cijfers invoeren.',
    ];

    public $setPage = true;

    public function updatedName()
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());
        $this->dispatch('set-loading-false');
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        try {
            $this->validate($this->rules());
        } catch (Throwable $e) {
            $this->dispatch('set-loading-false');
            throw $e;
        }
        if (session::has('survey-id')) {
            $this->form->createStudent($this->name, strtolower(session::get('survey-id')));
            $this->dispatch('step-up')->component(StepController::class);
        }
    }

    public function mount(): void
    {
        $this->name = old('student-name') ?? session::get('student-name') ?? '';

        if ($this->name) {
            $this->loading = false;
        }
    }

    public function render()
    {
        $this->loading = false;
        return view('livewire.forms.form-step2');
    }
}
