<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Session;
use Closure;
use Livewire\Component;

class FormStep20 extends Component
{
    public PostForm $form;

    public $stepId;
    public $nextEnabled;
    public $backEnabled;

    public $jsonQuestion;

    public $answerSelected = [];

    public $firstRequired = true;

    protected array $messages = [];

    public $basicTitle = "";

    public array $students = [];

    public array $startStudent = [];
    public int $studentCounter = 1;

    public int $answerId;
    public array $shadowStudents = [];

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
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['answer_id.required']);
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
        if (in_array($id, $this->answerSelected)) {
            $this->answerSelected = [];
        }
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());

        if(empty($this->startStudent)){
            $this->dispatch('set-step-id-up');

            return;
        }

        if (\Session::has('survey-student-class-id')) {
            $answer = [
                'id' => $this->startStudent['id'] ?? [],
                'value' => $this->answerSelected['id'] ?? [],
            ];

            $this->form->createAnswer([$answer], $this->jsonQuestion, $this->stepId);

            session::put(['student-good-knowing-student' => $this->answerSelected]);

            if (!empty($this->students)) {
                $this->startStudent = $this->students[0];
                $this->studentCounter++;
                $this->jsonQuestion->question_title = $this->basicTitle . " " . $this->studentCounter . " ID";

                $this->answerSelected = [];
                array_shift($this->students);

                if(empty($answer['value'])){
                    $this->dispatch('set-block-btn-animation', null);
                }

            } else {
                $this->dispatch('set-step-id-up');
            }
        }
    }

    public function mount(): void
    {
        $this->basicTitle = $this->jsonQuestion->question_title;
        $this->students = $this->form->getStudentsNotInFriendsSelected();

        if(!empty($this->students)){
            shuffle($this->students);

            $this->shadowStudents = $this->students;

            $this->startStudent = $this->students[0];
            $this->jsonQuestion->question_title = $this->basicTitle . " " . $this->studentCounter;

            // shifts the student shadow
            array_shift($this->students);
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step20');
    }
}
