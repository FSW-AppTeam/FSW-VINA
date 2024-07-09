<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStepSelectStudents extends Component
{
    public PostForm $form;

    public array $selectedStudents = [];

    public int $stepId;

    public $nextEnabled;

    public $backEnabled;

    public $jsonQuestion;

    public $savedAnswers;

    public $firstRequired = true;

    public array $students = [];

    public $subject = false; // used to show the subject of the question

    public array $finishedSubjects; //used to store the finished subjects.

    protected array $messages = [];

    protected $listeners = [
        'set-selected-student-id' => 'setSelectedStudent',
        'remove-selected-student-id' => 'removeSelectedStudent',
        'set-save-answer' => 'save',
    ];

    public function setSelectedStudent(int $id, string $name): void
    {
        $this->selectedStudents[] = ['id' => $id, 'name' => $name];
    }

    public function removeSelectedStudent(int $id): void
    {
        $key = array_search($id, array_column($this->selectedStudents, 'id'));

        unset($this->selectedStudents[$key]);
        //Rebase the key after the unset
        $this->selectedStudents = array_values($this->selectedStudents);
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
        $this->form->addRulesFromOutside($this->rules());

        $this->validate($this->rules());
        if ($this->jsonQuestion->question_type == 'json') {

            $this->setSubjects();
            $this->jsonQuestion->question_title = $this->jsonQuestion->question_title.' ID:'.$this->subject['id'];
        }

        $this->form->createAnswer(array_column($this->selectedStudents, 'id'), $this->jsonQuestion, $this->stepId);

        if ($this->subStepUp()) {
            return;
        }

        $this->dispatch('set-step-id-up');
    }

    public function mount(): void
    {
        $this->students = $this->form->getStudentsWithoutActiveStudent();

        $this->setSubjects();

        if (is_null($this->savedAnswers)) {
            return;
        }

        foreach ($this->students as $student) {
            if (in_array($student['id'], $this->savedAnswers)) {
                $this->selectedStudents[] = [
                    'id' => $student['id'],
                    'name' => $student['name'],
                ];
            }
        }

    }

    public function render()
    {
        return view('livewire.forms.form-step-select-students');
    }

    public function setSubjects()
    {
        if ($this->jsonQuestion->question_type !== 'json') {
            return;
        }

        $this->subject = array_shift($this->students);
        $this->finishedSubjects[] = $this->subject;
        $this->jsonQuestion->question_title = 'ID:'.$this->subject['id'];
    }

    public function subStepDown(): bool
    {
        if ($this->jsonQuestion->question_type !== 'json') {
            return false;
        }

        return true;
    }

    public function subStepUp(): bool
    {
        if ($this->jsonQuestion->question_type !== 'json') {
            return false;
        }

        if (count($this->students) < 2) {
            return false;
        }
        $this->dispatch('set-disable-next');
        $this->disappear = true;
        $this->dispatch('start-friend-bounce');
        $this->selectedStudents = [];

        return true;
    }
}
