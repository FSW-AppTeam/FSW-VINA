<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep10 extends Component
{
    public PostForm $form;

    public ?array $friends = [];

    public array $selectedFriendsIds = [];

    public int $stepId;

    public $nextEnabled;

    public $backEnabled;

    public $jsonQuestion;

    public $savedAnswers;

    public $firstRequired = true;

    public $index = 0;

    public $friendsList = [];

    protected array $messages = [];

    public $studentsWithoutActiveStudent = [];

    protected $listeners = [
        'set-selected-student-id-comp' => 'setSelectedStudentId',
        'remove-selected-student-id' => 'removeSelectedStudentId',
    ];

    public function setSelectedStudentId(int $id, string $name): void
    {
        $this->friends[] = ['id' => $id, 'name' => $name];
        $this->selectedFriendsIds[] = $id;

        $this->friendsList = [];
        $index = -1;

        foreach ($this->friends as $key => $friend) {
            if ($key % 5 === 0) {
                $index++;
            }

            if (isset($this->friendsList[$index])) {
                if (count($this->friendsList[$index]) < 5) {
                    $this->friendsList[$index][] = $friend;
                }
            } else {
                $this->friendsList[$index][] = $friend;
            }
        }
    }

    public function removeSelectedStudentId(int $id): void
    {
        $key = array_search($id, array_column($this->friends, 'id'));

        if (is_int($key)) {
            array_splice($this->friends, $key, 1);
            array_splice($this->selectedFriendsIds, $key, 1);

            $this->dispatch('set-disable-student-fade-btn', $id)->component('StudentFadeComponent');
        }

        foreach ($this->friendsList as $index => $friendList) {
            $key = array_search($id, array_column($friendList, 'id'));

            if (is_int($key)) {
                array_splice($this->friendsList[$index], $key, 1);
            }
        }
    }

    public function rules(): array
    {
        $this->messages['friends.required'] = $this->jsonQuestion->question_options['error_empty_text'];

        return [
            'friends' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['friends.required']);
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
        $this->form->createAnswer(array_column($this->friends, 'id'), $this->jsonQuestion, $this->stepId);
        $this->dispatch('set-step-id-up');
    }

    public function mount(): void
    {
        if (is_null($this->savedAnswers)) {
            return;
        }
        $allStudents = $this->form->getStudentsWithoutActiveStudent();
        foreach ($allStudents as $student) {
            if (in_array($student['id'], $this->savedAnswers)) {
                $this->friends[] = [
                    'id' => $student['id'],
                    'name' => $student['name'],
                ];
            }
        }

        // array to build the list for the view
        $index = -1;
        foreach ($this->friends as $key => $friend) {
            if ($key % 5 === 0) {
                $index++;
            }

            $this->friendsList[$index][] = $friend;
            $this->selectedFriendsIds[] = $friend['id'];
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step10');
    }
}
