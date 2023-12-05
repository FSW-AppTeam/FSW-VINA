<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep6 extends Component
{
    public PostForm $form;
    public int|null $classTime = null;

    public $stepId;

    public $jsonQuestion;

    public $setPage = true;

    public $firstRequired = true;

    protected $messages = [];

    protected $listeners = [
        'set-answer-block-answer-id' => 'setAnswerBlockAnswerId',
    ];

    public function rules(): array
    {
        $this->messages['classTime.required'] = $this->jsonQuestion->question_options->error_empty_text;

        return [
            'classTime' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['classTime.required']);
                    } else {
                        $this->setPage = false;
                    }
                }
            ],
        ];
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());

        if (\Session::has('survey-student-class-id')) {
            $this->form->createAnswer(!is_null($this->classTime) ? [$this->classTime] : [], $this->jsonQuestion, $this->stepId);

            \Session::put(['student-class-time' => $this->classTime ?? null]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->classTime = old('classTime') ?? \Session::get('student-class-time') ?? null;
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
