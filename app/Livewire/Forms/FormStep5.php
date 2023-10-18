<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswers;
use Closure;
use Livewire\Component;

class FormStep5 extends Component
{
    public PostForm $form;

    public int|null $educationDegree;

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
        $this->messages['education-degree.required'] = $this->jsonQuestion->question_options->error_empty_text;

        return [
            'educationDegree' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['education-degree.required']);
                    } else {
                        $this->setPage = false;
                    }
                }
            ],

        ];
    }

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
             $this->form->createAnswer([$this->educationDegree ?? null], $this->jsonQuestion, $this->stepId);

            \Session::put('student-education-degree', $this->educationDegree);

            $this->dispatch('set-step-id-up');
        }
    }

    public function setAnswerBlockAnswerId(int $id): void
    {
        $this->educationDegree = $id;
    }

    public function mount(): void
    {
        $this->educationDegree = old('education-degree') ?? \Session::get('student-education-degree');
    }

    public function render()
    {
        return view('livewire.forms.form-step5');
    }
}
