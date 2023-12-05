<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep15 extends Component
{
    public PostForm $form;

    public $stepId;

    public $jsonQuestion;

    public $answerSelected = [];

    public $firstRequired = true;

    protected array $messages = [];

    public $basicTitle = "";

    public array $students = [];

    public array $startStudent = [];
    public array $shadowStudents = [];
    public int $studentCounter = 1;

    public int $answerId;

    protected $listeners = [
        'set-answer-button-square' => 'setAnswerButtonSquare',
        'set-remove-student' => 'removeStudent',
        'set-remove-selected-square' => 'removeSelectedSquare',
        'set-save-answer' => 'save',
    ];

    public function rules(): array
    {
        $this->messages['answer_id.required'] = $this->jsonQuestion->question_options->error_empty_text;

        return [
            'answerSelected' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired) {
                        $this->firstRequired = false;

                        if (empty($value)) {
                            $fail($this->messages['answer_id.required']);
                        }
                    }
                },
                'array'
            ],
        ];
    }

    public function setAnswerButtonSquare(int $id, string $val): void
    {
        $this->answerSelected = ['id' => $id, 'value' => $val];
    }

    public function removeSelectedSquare(int $id): void
    {
        if(in_array($id, $this->answerSelected)){
            $this->answerSelected = [];
        }
    }

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
            if(!empty($this->answerSelected)){
                $answer = [
                    'id'    => $this->startStudent['id'],
                    'value' => $this->answerSelected['id'],
                ];
            } else {
                $answer = [
                    'id'    => $this->startStudent['id'],
                    'value' => [],
                ];
            }

            $this->form->createAnswer([$answer], $this->jsonQuestion, $this->stepId);

            \Session::put(['student-good-knowing-student' => $this->answerSelected]);

            if(array_key_exists(1, $this->students)){
                $this->startStudent = $this->students[0];
                $this->studentCounter ++;
                $this->jsonQuestion->question_title = $this->basicTitle . " " .  $this->studentCounter;
                $this->answerSelected = [];

                array_shift($this->students);

                // next button skip question
                if(empty($answer['value'])) {
                    $this->dispatch('set-block-btn-animation', null);
//                    array_shift($this->shadowStudents);
                }
            } else {
                $this->dispatch('set-step-id-up');
            }
        }
    }

    public function mount(): void
    {
//        $this->flagsSelected = old('flagsSelected') ?? \Session::get('student-knowing-student') ?? [];

        $this->basicTitle = $this->jsonQuestion->question_title;
        $this->jsonQuestion->question_title = $this->basicTitle . " " .  $this->studentCounter;
        $this->students = $this->form->getStudentsWithoutActiveStudent();

        shuffle($this->students);
        $this->shadowStudents = $this->students;

        if(!empty($this->students)){
            $this->startStudent = $this->students[0];
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step15');
    }
}
