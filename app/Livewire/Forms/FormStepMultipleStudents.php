<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormStepMultipleStudents extends Component
{
    public PostForm $form;

    public $stepId;

    public $nextEnabled;

    public $backEnabled;

    public $jsonQuestion;

    public $savedAnswers = [];

    public $questionOptions = [];

    public $answerSelected = [];

    public $firstRequired = true;

    protected array $messages = [];

    public $basicTitle = '';

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
        $this->messages['answer_id.required'] = $this->jsonQuestion->question_options['error_empty_text'];

        return [
            'answerSelected' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['answer_id.required']);
                    }
                },
                'array',
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

        $answer = [
            'student_id' => $this->startStudent['id'],
            'answer' => $this->answerSelected,
        ];
        $this->jsonQuestion->question_title = $this->basicTitle.' ID: '.$this->startStudent['id'];

        $this->form->createAnswer($answer, $this->jsonQuestion, $this->stepId);
        if (array_key_exists(0, $this->students)) {
            $this->studentCounter++;
            $this->answerSelected = [];
            $this->startStudent = array_shift($this->students);

            $this->jsonQuestion->question_title = $this->basicTitle.' ID: '.$this->startStudent['id'];
            $this->finishedStudent[] = $this->startStudent;
            $this->setDatabaseResponse();
            // next button skip question

            if (empty($this->answerSelected['value'])) {
                $this->dispatch('set-block-btn-animation', null);
            }
        } else {
            $this->disappear = false;
            $this->dispatch('set-step-id-up');
        }
    }

    public function stepDown(): void
    {
        if ($this->studentCounter <= 1) {
            $this->dispatch('set-step-id-down');

            return;
        }
        if (! empty($this->finishedStudent)) {
            array_unshift($this->students, array_pop($this->finishedStudent));
            $this->startStudent = end($this->finishedStudent);
            $this->jsonQuestion->question_title = $this->basicTitle.' ID: '.$this->startStudent['id'];

        }
        $this->answerSelected = [];
        $this->setDatabaseResponse();
        $this->studentCounter--;
    }

    public function mount(): void
    {
        $this->basicTitle = $this->jsonQuestion->question_title;
        $this->jsonQuestion->question_title = $this->basicTitle.' '.$this->studentCounter;
        $this->students = $this->form->getStudentsWithoutActiveStudent();
        if ($this->jsonQuestion->depends_on_question !== null) {
            $this->students = $this->form->getStudentsWithResponse($this->jsonQuestion->depends_on_question);

            if (count($this->students) == 0) {
                $this->dispatch('set-step-id-up');

                return;
            }
        }

        shuffle($this->students);
        $this->shadowStudents = $this->students;

        if (! empty($this->students)) {
            $this->startStudent = array_shift($this->students);
            $this->jsonQuestion->question_title = $this->basicTitle.' ID: '.$this->startStudent['id'];
            $this->finishedStudent[] = $this->startStudent;
        }
        $this->setDatabaseResponse();
    }

    public function render()
    {
        $dependsOnQuestion = SurveyQuestion::find($this->jsonQuestion->depends_on_question);
        foreach ($dependsOnQuestion->question_answer_options as $option) {
            if ($option['id'] == json_decode($this->startStudent['student_answer'])->country_id) {
                $otherCountry = $option['value'];
            }
        }
        switch (json_decode($this->startStudent['student_answer'])->country_id) {
            case 1:
                $this->stepId++;
                $this->dispatch('set-step-id-up');
                return;
            case 2:
            case 3:
            case 4:
                $this->questionOptions = getCountriesByName()[$otherCountry];
                break;
            case 5:
                $this->questionOptions = getCountriesByName()['Nederlandse Antillen'];
                break;
            case 6:
                $this->questionOptions = getCountriesByName()[json_decode($this->startStudent['student_answer'])->other_country];
                break;
        }

        return view('livewire.forms.form-step-multiple-students');
    }

    public function setDatabaseResponse()
    {
        $response = SurveyAnswer::where('student_id', $this->form->getStudent()->id)
            ->where('question_id', $this->jsonQuestion->id)
            ->whereJsonContains('student_answer->student_id', $this->startStudent['id'])
            ->first();

        if (! $response) {
            Log::info('NIET gevonden'.$this->startStudent['id']);

            return;
        }

        foreach ($this->jsonQuestion->question_answer_options as $key => $option) {
            if (! empty($response->student_answer['answer']) && $option['id'] == $response->student_answer['answer']['id']) {
                $this->setAnswerButtonSquare(
                    $response->student_answer['answer']['id'],
                    $this->jsonQuestion->question_answer_options[$key]['value']);

                return;
            }
        }
    }
}
