<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswer;
use Closure;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Throwable;

class FormStepSelectMultiple extends Component
{
    public PostForm $form;

    public $stepId;

    public $nextEnabled;

    public $backEnabled;

    public $jsonQuestion;

    public $savedAnswers;

    public $questionOptions = [null, null, null];

    public $answerSelected = [];

    public $firstRequired = true;

    protected array $messages = [];

    public array $students = [];

    public $subject = false; // used to show the subject of the question

    public array $finishedSubjects; //used to store the finished subjects.

    public int $answerId;

    protected $listeners = [
        'set-answer-button-square' => 'setAnswerButtonSquare',
        'set-remove-student' => 'removeStudent',
        'set-remove-selected-square' => 'removeSelectedSquare',
        'set-sub-step-id-down' => 'stepDown',
        'save' => 'save',
    ];

    public function rules(): array
    {
        $this->messages['answer_id.required'] = $this->jsonQuestion->question_options['error_empty_text'];

        return [
            'answerSelected' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['answerSelected.required']);
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
        try {
            $this->validate($this->rules());
        } catch (Throwable $e) {
            $this->dispatch('set-enable-all');
            throw $e;
        }
        $answer = [
            'student_id' => $this->subject['id'],
            'value' => array_column($this->answerSelected, 'id'),
        ];
        $this->jsonQuestion->question_title = $this->jsonQuestion->question_title.' ID:'.$this->subject['id'];
        $this->form->createAnswer($answer, $this->jsonQuestion, $this->stepId);

        if (array_key_exists(1, $this->students)) {

            /*            $this->startStudent = array_shift($this->students);
                        $this->jsonQuestion->question_title = $this->basicTitle.' ID: '.$this->startStudent['id'];
                        $this->finishedStudent[] = $this->startStudent;
                        $this->setDatabaseResponse();
                        // next button skip question

                        if (empty($this->answerSelected['value'])) {*/
            $this->dispatch('set-block-btn-animation', null);
            //            }
        } else {
            //            $this->disappear = false;
            $this->dispatch('step-up')->component(StepController::class);
        }
    }

    public function stepDown(): void
    {
        if ($this->studentCounter <= 1) {
            $this->dispatch('set-step-id-down');

            return;
        }

        if (! empty($this->finishedSubjects)) {
            array_unshift($this->students, array_pop($this->finishedSubjects));
            $this->subject = end($this->finishedSubjects);
        }
        $this->finishedSubjects = [];
        $this->setDatabaseResponse();
    }

    public function mount(): void
    {
        $this->students = $this->form->getStudentsWithoutActiveStudent();
        if($this->jsonQuestion->depends_on_question) {
            $this->students = $this->form->getStudentsOtherEthnicityWithResponse($this->jsonQuestion->depends_on_question);
        }

        $this->subject = array_shift($this->students);
        $this->finishedSubjects[] = $this->subject;
        $this->setDatabaseResponse();
    }

    public function render()
    {
        return view('livewire.forms.form-step-select-multiple');
    }

    public function setDatabaseResponse()
    {
        $response = SurveyAnswer::where('student_id', $this->form->getStudent()->id)
            ->where('question_id', $this->jsonQuestion->id)
            ->whereJsonContains('student_answer->student_id', $this->subject['id'])
            ->first();
        if (! $response) {
            Log::info('NIET gevonden'.$this->subject['id']);

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
