<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep4 extends Component
{
    public PostForm $form;

    public int|null $gender;

    public $stepId;

    public $jsonQuestion;

    public $firstRequired = true;

    protected $messages = [];

    public $setPage = true;

    protected $listeners = [
        'set-answer-block-answer-id' => 'setAnswerBlockAnswerId',
    ];

    public function rules(): array
    {
        $this->messages['gender.required'] = $this->jsonQuestion->question_options->error_empty_text;

        return [
            'gender' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['gender.required']);
                    } else {
                        $this->setPage = false;
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
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
             $this->form->createAnswer([$this->gender ?? 0], $this->jsonQuestion, $this->stepId);

            \Session::put('student-gender', $this->gender);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
        $this->gender = old('gender') ?? \Session::get('student-gender') ?? null;
    }

    public function render()
    {
        return view('livewire.forms.form-step4');
    }
}
