<?php

namespace App\Livewire\Forms;

use App\Livewire\Partials\FormButtons;
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

    public $questionOptions = [];

    public $answerSelected = [];

    public $firstRequired = true;

    protected array $messages = [];

    public array $students = [];

    public $subject = false; // used to show the subject of the question

    public $bounceOut = false;

    public $showShrink;

    public $disabledBtn = false;

    public array $finishedSubjects; //used to store the finished subjects.

    public int $answerId;

    protected $listeners = [

        'set-show-shrink-true' => 'setShowShrinkTrue',
        'set-bounce-out-true' => 'setBounceOutTrue',
        'set-answer-button-square' => 'setAnswerButtonSquare',
        'set-remove-student' => 'removeStudent',
        'set-remove-selected-square' => 'removeSelectedSquare',
        'set-sub-step-down' => 'stepDown',
        'set-sub-step-up' => 'stepUp',
        'save' => 'save',
    ];

    public function rules(): array
    {
        $this->messages['answerSelected.required'] = $this->jsonQuestion->question_options['error_empty_text'];

        return [
            'answerSelected' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $this->dispatch('set-enable-all')->component(FormButtons::class);
                        $fail($this->messages['answerSelected.required']);
                    }
                },
                'array',
            ],
        ];
    }

    public function setBounceOutTrue()
    {
        $this->bounceOut = true;
    }

    public function setShowShrinkTrue(): void
    {
        $this->showShrink = true;
    }

    public function setAnswerButtonSquare(int $id, string $val): void
    {
        $this->answerSelected = ['id' => $id, 'value' => $val];
        $this->setBounceOutTrue();

        $this->save();
    }

    public function removeSelectedSquare(int $id): void
    {
        if (in_array($id, $this->answerSelected)) {
            $this->answerSelected = [];
        }
    }

    public function save(): void
    {
        $this->dispatch('set-disable-next');
        $this->disabledBtn = true;
        $this->form->addRulesFromOutside($this->rules());
        try {
            $this->validate($this->rules());
        } catch (Throwable $e) {
            $this->disabledBtn = false;
            $this->dispatch('set-enable-all')->component(FormButtons::class);
            throw $e;
        }
        $answer = [
            'student_id' => $this->subject['id'],
            'value' => array_key_exists('id', $this->answerSelected) ? $this->answerSelected['id'] : 99,
        ];
        $this->jsonQuestion->question_title = $this->jsonQuestion->question_title.' ID:'.$this->subject['id'];
        $this->form->createAnswer($answer, $this->jsonQuestion, $this->stepId);
        if (! array_key_exists('id', $this->answerSelected)) {
            $this->stepUp();
        }
    }

    public function stepUp(): void
    {
        $this->answerSelected = [];
        $this->subject = array_shift($this->students);
        $this->finishedSubjects[] = $this->subject;
        $this->setDatabaseResponse();
        $this->bounceOut = false;
        $this->disabledBtn = false;
        $this->showShrink = false;
        if (count($this->students) == 0 && $this->subject == null) {
            $this->dispatch('step-up')->component(StepController::class);
        }
        $this->dispatch('set-enable-all');
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
        $this->setStudents();
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
        if (empty($this->subject)) {
            return;
        }
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

    public function setStudents(): void
    {
        // By default, set al students:
        $this->students = $this->form->getStudentsWithoutActiveStudent();
        if ($this->jsonQuestion->depends_on_question) {
            // Get students based on the response of another question:
            $this->students = $this->form->getStudentsOtherEthnicityWithResponse($this->jsonQuestion->depends_on_question);
        }
        if ($this->jsonQuestion->id == 49) {
            // exception, question id 49 had specific logic.
            $this->students = $this->form->getStudentsFotQuestion49($this->jsonQuestion->depends_on_question);
        }
    }
}
