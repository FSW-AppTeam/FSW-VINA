<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep5 extends Component
{
    public PostForm $form;

    public int|null $educationDegree = null;

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
        $this->messages['education-degree.required'] = $this->jsonQuestion->question_options['error_empty_text'];

        return [
            'educationDegree' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['education-degree.required']);
                    }
                }
            ],

        ];
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());

         $this->form->createAnswer($this->educationDegree, $this->jsonQuestion, $this->stepId);

        $this->dispatch('set-step-id-up');
    }

    public function updatedEducationDegree()
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());
        $this->dispatch('set-enable-next');
    }

    public function setAnswerBlockAnswerId(int $id): void
    {
        $this->educationDegree = $id;
    }

    public function mount(): void
    {
        $this->educationDegree = $this->savedAnswers ?? null;
        if($this->educationDegree) {
            $this->nextEnabled = true;
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step5');
    }
}
