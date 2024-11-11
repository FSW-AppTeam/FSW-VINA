<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;
use Throwable;

class FormStep3 extends Component
{
    public PostForm $form;

    public ?int $age = null;

    public $stepId;

    public $loading = true;

    public $jsonQuestion;

    public $savedAnswers;

    public $firstRequired = true;

    protected $messages = [];

    protected $listeners = [
        'save' => 'save',
    ];

    public function rules(): array
    {
        $rules = [
            'age' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $this->dispatch('set-loading-false');
                        $fail($this->messages['age.required']);
                    }
                },
            ],
        ];

        if (isset($this->age)) {
            $rules['age'] = ['integer', 'min:1950', 'max:2020'];
        }

        if (! $this->firstRequired) {
            $rules['age'] = ['nullable'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'age.required' => $this->jsonQuestion->question_options['error_empty_text'],
            'age.integer' => __('validation.between.numeric', ['Attribute' => 'Je geboortejaar', 'min' => 1950, 'max' => 2020]),
            'age.min' => __('validation.between.numeric', ['Attribute' => 'Je geboortejaar', 'min' => 1950, 'max' => 2020]),
            'age.max' => __('validation.between.numeric', ['Attribute' => 'Je geboortejaar', 'min' => 1950, 'max' => 2020]),
        ];
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
        $this->form->createAnswer($this->age, $this->jsonQuestion, $this->stepId);
        $this->dispatch('step-up')->component(StepController::class);
    }

    public function updatedAge()
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());
        $this->dispatch('set-loading-false');
    }

    public function mount(): void
    {
        $this->age = $this->savedAnswers ?? null;
        if ($this->age) {
            $this->loading = false;
        }
    }

    public function render()
    {
        $this->loading = false;

        return view('livewire.forms.form-step3');
    }
}
