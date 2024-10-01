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

    public $answerSelected = [];

    public $stepId;

    public $loading = true;

    public $jsonQuestion;

    public $savedAnswers;

    public $firstRequired = true;

    public array $students = [];

    public $subject = false; // used to show the subject of the question

    public array $finishedSubjects; //used to store the finished subjects.

    public $disappear = false;

    protected array $messages = [];

    public $questionOptions = [];

    public $showShrink;

    public $disabledBtn = false;

    protected $listeners = [
        'set-show-shrink-true' => 'setShowShrinkTrue',
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
                        $this->dispatch('set-loading-false')->component(FormButtons::class);
                        $fail($this->messages['answerSelected.required']);
                    }
                },
                'array',
            ],
        ];
    }

    public function setShowShrinkTrue(): void
    {
        $this->showShrink = true;
    }

    public function setAnswerButtonSquare(int $id, string $val): void
    {
        $this->answerSelected = ['id' => $id, 'value' => $val];
        $this->save();
    }

    public function removeSelectedSquare(int $id): void
    {
        if (in_array($id, $this->answerSelected)) {
            $this->answerSelected = [];
        }
        $this->disabledBtn = false;
    }

    public function save(): void
    {
        $this->dispatch('set-loading-true');
        $this->disabledBtn = true;
        $this->form->addRulesFromOutside($this->rules());
        try {
            $this->validate($this->rules());
        } catch (Throwable $e) {
            $this->disabledBtn = false;
            $this->dispatch('set-loading-false')->component(FormButtons::class);
            throw $e;
        }
        $answer = [
            'student_id' => $this->subject['id'],
            'value' => array_key_exists('id', $this->answerSelected) ? $this->answerSelected['id'] : 99,
        ];
        $this->jsonQuestion->question_title = $this->jsonQuestion->question_title.' ID:'.$this->subject['id'];
        $this->form->createAnswer($answer, $this->jsonQuestion, $this->stepId);

        if (array_key_exists(0, $this->students)) {
            $this->stepUp();
        } else {
            $this->dispatch('step-up')->component(StepController::class);
        }
    }

    public function stepUp(): void
    {
        $this->answerSelected = [];
        $this->subject = array_shift($this->students);
        $this->finishedSubjects[] = $this->subject;

        if (count($this->students) == 0 && $this->subject == null) {
            $this->dispatch('step-up')->component(StepController::class);
        }
        $this->disabledBtn = $this->setDatabaseResponse();
        $this->dispatch('set-loading-false');
    }

    public function stepDown(): void
    {
        if (count($this->finishedSubjects) <= 1) {
            $this->dispatch('step-down')->component(StepController::class);

            return;
        }

        if (! empty($this->finishedSubjects)) {
            array_unshift($this->students, array_pop($this->finishedSubjects));
            $this->subject = end($this->finishedSubjects);
        }

        $this->answerSelected = [];

        $this->disabledBtn = $this->setDatabaseResponse();
    }

    public function mount(): void
    {
        $this->setStudents();
        shuffle($this->students);
        $this->subject = array_shift($this->students);
        $this->finishedSubjects[] = $this->subject;

        $this->disabledBtn = $this->setDatabaseResponse();
    }

    public function render()
    {
        $this->loading = false;
        if ($this->jsonQuestion->depends_on_question !== null && $this->subject !== null) {
            $this->questionOptions = setNationalityOptions($this->jsonQuestion->depends_on_question, $this->subject['id']);
        }

        return view('livewire.forms.form-step-select-multiple');
    }

    public function setDatabaseResponse()
    {
        if (empty($this->subject)) {
            $this->dispatch('step-up')->component(StepController::class);
            return false;
        }
        $response = SurveyAnswer::where('student_id', $this->form->getStudent()->id)
            ->where('question_id', $this->jsonQuestion->id)
            ->whereJsonContains('student_answer->student_id', $this->subject['id'])
            ->first();
        if (! $response) {
            Log::info('NIET gevonden'.$this->subject['id']);

            return false;
        }

        if (! $response->student_answer['value']) {
            //Participant heeft deze vraag overgeslagen.
            $this->dispatch('set-loading-false')->component(FormButtons::class);
            return true;
        }

        foreach ($this->jsonQuestion->question_answer_options as $key => $option) {
            if (! empty($response->student_answer['value']) && $option['id'] == $response->student_answer['value']) {
                $this->answerSelected = ['id' => $response->student_answer['value'], 'value' => $this->jsonQuestion->question_answer_options[$key]['value']];
            }
        }

        $this->dispatch('set-loading-false')->component(FormButtons::class);
        return true;
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
