<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep4 extends Component
{
    public PostForm $form;

    public int|null $gender = null;

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
        $this->messages['gender.required'] = $this->jsonQuestion->question_options['error_empty_text'];

        return [
            'gender' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['gender.required']);
                    }
                }
            ],

        ];
    }

    public function setAnswerBlockAnswerId(int $id): void
    {
        $this->gender = $id;
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());

        $this->form->createAnswer($this->gender, $this->jsonQuestion, $this->stepId);
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
        $this->gender = $this->savedAnswers ?? null;
        if($this->gender) {
            $this->nextEnabled = true;
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step4');
    }
}
