<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep6 extends Component
{
    public PostForm $form;
    public int|null $classTime = null;

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
        $this->messages['classTime.required'] = $this->jsonQuestion->question_options['error_empty_text'];

        return [
            'classTime' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['classTime.required']);
                    }
                }
            ],
        ];
    }

    public function updatedClassTime()
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());
        $this->dispatch('set-enable-next');
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());

        $this->form->createAnswer($this->classTime, $this->jsonQuestion, $this->stepId);
        $this->dispatch('set-step-id-up');
    }

    public function mount(): void
    {
        $this->classTime = $this->savedAnswers ?? null;
        if($this->classTime) {
            $this->nextEnabled = true;
        }
    }

    public function setAnswerBlockAnswerId(int $id): void
    {
        $this->classTime = $id;
    }

    public function render()
    {
        return view('livewire.forms.form-step6');
    }
}
