<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStepSelect extends Component
{
    public PostForm $form;

    public int|null $input = null;

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;
    public $savedAnswers;

    public $firstRequired = true;

    protected $messages = [];

    protected $listeners = [
        'set-answer-block-answer-id' => 'setAnswerBlockAnswerId',
    ];

    public function rules(): array
    {
        if(isset($this->jsonQuestion->question_options['error_empty_text'])) {
            $this->messages['input.required'] = $this->jsonQuestion->question_options['error_empty_text'];
        }

        return [
            'input' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['input.required']);
                    }
                }
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
        $this->validate($this->rules());

        $this->form->createAnswer($this->input, $this->jsonQuestion, $this->stepId);
        $this->dispatch('set-step-id-up');
    }

    public function updatedGender()
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());
        $this->dispatch('set-enable-next');
    }


    public function mount(): void
    {
        $this->input = $this->savedAnswers ?? null;
        if($this->input) {
            $this->nextEnabled = true;
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step-select');
    }
}
