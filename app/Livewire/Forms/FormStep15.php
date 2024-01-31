<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswers;
use Closure;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class FormStep15 extends Component
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
    public array $finishedStudent = [];
    public array $shadowStudents = [];
    public int $studentCounter = 1;

    public int $answerId;

    protected $listeners = [
        'set-answer-button-square' => 'setAnswerButtonSquare',
        'set-remove-student' => 'removeStudent',
        'set-remove-selected-square' => 'removeSelectedSquare',
        'set-sub-step-id-down' => 'stepDown',
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
        if(in_array($id, $this->answerSelected)){
            $this->answerSelected = [];
        }
    }

    public function save(): void
    {
        $this->form->addRulesFromOutside($this->rules());
        $this->validate($this->rules());

        if (session::has('survey-id')) {
            $answer = [
                'student_id'    => $this->startStudent['id'],
                'answer' => $this->answerSelected,
            ];

            $this->form->createAnswer($answer, $this->jsonQuestion, $this->stepId);
            if(array_key_exists(0, $this->students)){
                $this->studentCounter ++;
                $this->answerSelected = [];
                $this->startStudent =  array_shift($this->students);
                $this->jsonQuestion->question_title = $this->basicTitle . " " .  $this->studentCounter;
                $this->finishedStudent[] = $this->startStudent;
                $this->setDatabaseResponse();
                // next button skip question

//                if(empty($this->answerSelected['value'])) {
                    $this->dispatch('set-block-btn-animation', null);
//                }
            } else {
                $this->disappear = false;
                $this->dispatch('set-step-id-up');
            }
        }
    }

    public function stepDown(): void
    {
        if($this->studentCounter <= 1) {
            $this->dispatch('set-step-id-down');
            return;
        }
        if(!empty($this->finishedStudent)) {
            array_unshift($this->students, array_pop($this->finishedStudent));
            $this->startStudent = end($this->finishedStudent);
            $this->jsonQuestion->question_title = $this->basicTitle . " ID: " . $this->startStudent['id'];

        }
        $this->answerSelected = [];
        $this->setDatabaseResponse();
        $this->studentCounter --;
    }

    public function mount(): void
    {
        $this->basicTitle = $this->jsonQuestion->question_title;
        $this->jsonQuestion->question_title = $this->basicTitle . " " .  $this->studentCounter;
        $this->students = $this->form->getStudentsWithoutActiveStudent();

//        shuffle($this->students);
        $this->shadowStudents = $this->students;

        if(!empty($this->students)){
            $this->startStudent =  array_shift($this->students);
            $this->jsonQuestion->question_title = $this->basicTitle . " " .  $this->studentCounter;
            $this->finishedStudent[] = $this->startStudent;
        }
        $this->setDatabaseResponse();
    }

    public function render()
    {
        return view('livewire.forms.form-step15');
    }


    public function setDatabaseResponse()
    {
        $response = SurveyAnswers::where('student_id', $this->form->getStudent()->id)
            ->where('question_id', $this->stepId)
            ->whereJsonContains('student_answer->student_id', $this->startStudent['id'])
            ->first();

        if(!$response) {
            Log::info('NIET gevonden' . $this->startStudent['id'] );
            return;
        }

        foreach($this->jsonQuestion->question_answer_options as $key => $option) {
            if($option->id == $response->student_answer['answer']['id']) {
                $this->setAnswerButtonSquare(
                    $response->student_answer['answer']['id'],
                    $this->jsonQuestion->question_answer_options[$key]->value);
                return;
            }
        }
    }
}
