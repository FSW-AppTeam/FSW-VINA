<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class FormStep22 extends Component
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
    public array $startStudentRelation = [];
    public array $studentRelationIds = [];
    public array $shadowStudents = [];

    public int $answerId;

    public $studentCounter = 1;

    public const SELF_ID_TEXT = 'Jou';

    protected $listeners = [
        'set-answer-button-square' => 'setAnswerButtonSquare',
        'set-remove-student' => 'removeStudent',
        'set-remove-selected-square' => 'removeSelectedSquare',
        'set-save-answer' => 'save',
    ];

    public function rules(): array
    {
        $this->messages['answer_selected.required'] = $this->jsonQuestion->question_options->error_empty_text;

        return [
            'answerSelected' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['answer_selected.required']);
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

        if (session::has('survey-student-class-id')) {
            $answer = [
                'id' => $this->startStudent['id'] ?? [],
                'relation_id' => $this->startStudentRelation['id'] ?? [],
                'value' => $this->answerSelected['id'] ?? [],
            ];

            $this->form->createAnswer([$answer], $this->jsonQuestion, $this->stepId);

            session::put(['student-connection-relation-student' => $this->answerSelected]);

            if (!empty($this->studentRelationIds)) {
                array_shift($this->studentRelationIds);

                if(empty($this->answerSelected['id'])){
                    array_shift($this->shadowStudents);
                }

                if (!empty($this->studentRelationIds)) {
                    $this->startStudent = $this->getStudentById($this->studentRelationIds[0]['id']);
                    $this->startStudentRelation = $this->getStudentById($this->studentRelationIds[0]['relation_id']);
                    $this->studentCounter++;

                    $this->jsonQuestion->question_title = $this->basicTitle . " " . $this->studentCounter;
                    $this->answerSelected = [];
                } else {
                    $this->dispatch('set-step-id-up');
                }
            } else {
                $this->dispatch('set-step-id-up');
            }
        }
    }

    public function getStudentById(int $id)
    {
        $key = array_search($id, array_column($this->students, 'id'));

        if (is_int($key)) {
            $this->students[$key]['name'] = substr($this->students[$key]['name'], 0, 15);

            return $this->students[$key];
        }

        return null;
    }

    public function mount(): void
    {
        $this->basicTitle = $this->jsonQuestion->question_title;
        $questionSet = $this->form->getStudentsFriendsRelationsSelected();
        $this->jsonQuestion->question_title = $this->basicTitle . " " . $this->studentCounter;

        $this->students = $questionSet['students'];
        $this->studentRelationIds = $questionSet['relations'];

        if (!empty($this->students)) {
            $this->startStudent = $this->getStudentById($this->studentRelationIds[0]['id']) ?? [];
            $this->startStudentRelation = $this->getStudentById($this->studentRelationIds[0]['relation_id']) ?? [];

            shuffle($this->studentRelationIds);
            $this->shadowStudents = $this->studentRelationIds;
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step22')->with([
            'selfStudentId' => $this->form->getStudent()->id,
            'selfText' => self::SELF_ID_TEXT,
        ]);
    }
}
