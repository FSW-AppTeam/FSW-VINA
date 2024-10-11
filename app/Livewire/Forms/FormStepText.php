<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;
use Throwable;

class FormStepText extends Component
{
    public PostForm $form;

    public ?string $input = null;

    public $stepId;

    public $loading = true;

    public $jsonQuestion;

    public $savedAnswers;

    public $firstRequired = true;

    protected $messages = [];

    protected $listeners = [
        'set-answer-block-answer-id' => 'setAnswerBlockAnswerId',
        'save' => 'save',
    ];

    public function rules(): array
    {
        if (isset($this->jsonQuestion->question_options['error_empty_text'])) {
            $this->messages['input.required'] = $this->jsonQuestion->question_options['error_empty_text'];
        }

        $rules = [
            'input' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $this->dispatch('set-loading-false');
                        $fail($this->messages['input.required']);
                    }
                },
            ],
        ];

        if (isset($this->jsonQuestion->question_options['validation_max'])) {
            $rules['input'] = 'max:'.$this->jsonQuestion->question_options['validation_max'];
        }

        return $rules;
    }

    public function updatedInput()
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());
        $this->dispatch('set-loading-false');
    }

    public function setAnswerBlockAnswerId($id): void
    {
        $this->input = $id;
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
        $this->form->createAnswer($this->input, $this->jsonQuestion, $this->stepId);
        $this->dispatch('step-up')->component(StepController::class);
    }

    public function mount(): void
    {
        $this->input = $this->savedAnswers ?? null;
        if ($this->input) {
            $this->loading = false;
        }
    }

    public function render()
    {
        $this->loading = false;

        return view('livewire.forms.form-step-text');
    }
}
