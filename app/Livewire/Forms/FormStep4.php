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

    public $firstRequired = true;

    protected $messages = [];

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

        if (\Session::has('survey-id')) {
             $this->form->createAnswer(!is_null($this->gender) ? [$this->gender] : [], $this->jsonQuestion, $this->stepId);

            \Session::put('student-gender', $this->gender ?? null);

            $this->dispatch('set-step-id-up');
        }
    }

    public function updatedGender()
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());
        $this->dispatch('set-enable-next');
    }


    public function mount(): void
    {
        $this->gender = old('gender') ?? \Session::get('student-gender') ?? null;
        if($this->gender) {
            $this->nextEnabled = true;
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step4');
    }
}
