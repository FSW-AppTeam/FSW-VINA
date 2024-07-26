<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswer;
use App\Models\SurveyStudent;
use Closure;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Throwable;

class FormStepSelectForSubject extends Component
{
    public PostForm $form;

    public array $selectedStudents = [];

    public int $stepId;

    public $loading = true;

    public $jsonQuestion;

    public $savedAnswers;

    public $firstRequired = true;

    public array $students = [];

    public $subject = false; // used to show the subject of the question

    public array $finishedSubjects; //used to store the finished subjects.

    public $disappear = false;

    protected array $messages = [];

    protected $listeners = [
        'set-selected-student-id' => 'setSelectedStudent',
        'remove-selected-student-id' => 'removeSelectedStudent',
        'set-sub-step-down' => 'stepDown',
        'set-sub-step-up' => 'stepUp',
        'save' => 'save',
    ];

    public function setSelectedStudent(int $id, string $name): void
    {
        $this->selectedStudents[] = ['id' => $id, 'name' => $name];
    }

    public function removeSelectedStudent(int $id): void
    {
        $key = array_search($id, array_column($this->selectedStudents, 'id'));
        if (is_int($key)) {
            array_splice($this->selectedStudents, $key, 1);
        }
    }

    public function rules(): array
    {
        $this->messages['selectedStudents.required'] = $this->jsonQuestion->question_options['error_empty_text'];

        return [
            'selectedStudents' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['selectedStudents.required']);
                    }
                },
                'array',
            ],
        ];
    }

    public function save(): void
    {
        try {
            $this->validate($this->rules());
        } catch (Throwable $e) {
            $this->dispatch('set-loading-false');
            throw $e;
        }
        $answer = [
            'student_id' => $this->subject['id'],
            'value' => array_column($this->selectedStudents, 'id'),
        ];
        $this->jsonQuestion->question_title = $this->jsonQuestion->question_title.' ID:'.$this->subject['id'];

        $this->form->createJsonAnswer($answer, $this->jsonQuestion, $this->stepId);
        $this->disappear = true;

        if (array_key_exists(1, $this->students)) {
            $this->dispatch('set-loading-true');
            $this->disappear = true;
            $this->dispatch('start-friend-bounce');
        } else {
            $this->dispatch('step-up')->component(StepController::class);
        }
    }

    public function stepDown(): void
    {
        $this->disappear = false;
        if (count($this->students) <= 1) {
            $this->dispatch('set-step-id-down', true);
            return;
        }

        if (! empty($this->finishedSubjects)) {
            array_unshift($this->students, array_pop($this->finishedSubjects));
            $this->subject = end($this->finishedSubjects);
        }
        $this->finishedSubjects = [];
        $this->setDatabaseResponse();
    }

    public function stepUp(): void
    {
        $this->selectedStudents = [];
        $this->subject = array_shift($this->students);
        $this->finishedSubjects[] = $this->subject;

        $this->setDatabaseResponse();

        $this->dispatch('set-loading-false');
    }

    public function mount(): void
    {
        $this->students = $this->form->getStudentsWithoutActiveStudent();

        $this->subject = array_shift($this->students);
        $this->finishedSubjects[] = $this->subject;
        $this->setDatabaseResponse();
    }

    public function render()
    {
        $this->loading = false;
        return view('livewire.forms.form-step-select-subjects');
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

        foreach ($response->student_answer['value'] as $responseItem) {
            $student = SurveyStudent::find($responseItem);
            if ($student) {
                $this->setSelectedStudent($responseItem, $student->name);
            }
        }
    }
}
