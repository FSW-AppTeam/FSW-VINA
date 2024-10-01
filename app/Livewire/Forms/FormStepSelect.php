<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;
use Throwable;

class FormStepSelect extends Component
{
    public PostForm $form;

    public ?int $input = null;

    public $stepId;

    public $loading = true;

    public $jsonQuestion;

    public $questionOptions = [];

    public $savedAnswers;

    public $firstRequired = true;

    protected $messages = [];

    protected $listeners = [
        'save' => 'save',
    ];

    public function rules(): array
    {
        if (isset($this->jsonQuestion->question_options['error_empty_text'])) {
            $this->messages['input.required'] = $this->jsonQuestion->question_options['error_empty_text'];
        }

        return [
            'input' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['input.required']);
                    }
                },
            ],

        ];
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
        return view('livewire.forms.form-step-select');
    }
}
