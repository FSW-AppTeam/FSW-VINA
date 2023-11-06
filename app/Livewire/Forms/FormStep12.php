<?php

namespace App\Livewire\Forms;

use Closure;
use Livewire\Component;

class FormStep12 extends Component
{
    public PostForm $form;
    public $basicTitle = "";
    public array $friends = [];
    public array $selectedFriendsIds = [];

    public array $students = [];
    public array $startFriend = [];

    public int $stepId;

    public \stdClass $jsonQuestion;

    public $firstRequired = true;

    public $studentCounter = 1;

    protected array $messages = [];

    public $setPage = true;

    public $index = 0;
    public $friendsList = [];

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

        foreach ($this->friends as $key => $friend){
            if($key % 5 === 0){
                $index++;
            }

            if(isset($this->friendsList[$index])){
                if (count($this->friendsList[$index]) < 5){
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

        if(is_int($key)){
            array_splice($this->friends, $key, 1);
            array_splice($this->selectedFriendsIds, $key, 1);

            $this->dispatch('set-disable-student-fade-btn',  $id)->component('StudentFadeComponent');
        }

        foreach ($this->friendsList as $index => $friendList){
            $key = array_search($id, array_column($friendList, 'id'));

            if(is_int($key)){
                array_splice($this->friendsList[$index], $key, 1);
            }
        }
    }

    public function rules(): array
    {
        $this->messages['friends.required'] = $this->jsonQuestion->question_options->error_empty_text;

        return [
            'friends' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired && empty($value)) {
                        $this->firstRequired = false;
                        $fail($this->messages['friends.required']);
                    }
//                    else {
//                        $this->setPage = false;
//                    }
                },
                'array'
            ]
        ];
    }

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
            $answer = [
                'id' => $this->startFriend['id'],
                'value' => array_column($this->friends, 'id'),
            ];

            $this->form->createAnswer([$answer], $this->jsonQuestion, $this->stepId);

            \Session::put(['student-friends-frequent' => $this->friends]);

            if(array_key_exists(1, $this->students)){
                $this->startFriend = $this->students[0];
                $this->studentCounter ++;

                foreach ($this->selectedFriendsIds as $id){
                    $this->dispatch('set-disable-student-fade-btn',  $id)->component('StudentFadeComponent');
                }

                $this->friends = [];
                $this->selectedFriendsIds = [];
                $this->jsonQuestion->question_title = $this->basicTitle . " " .  $this->studentCounter;
                $this->friendsList = [];

                array_shift($this->students);
            } else {
                $this->dispatch('set-step-id-up');
            }
        }
    }

    public function mount(): void
    {
//        $this->friends = old('friends') ?? \Session::get('student-friends-frequent') ?? [];

        $this->basicTitle = $this->jsonQuestion->question_title;
        $this->students = $this->form->getStudentsWithoutActiveStudent();

        if(empty($this->friends)){
            $this->startFriend = $this->students[0];
            array_shift($this->students);

            $this->jsonQuestion->question_title = $this->basicTitle . " " .  $this->studentCounter;
        }

        $index = -1;
        foreach ($this->friends as $key => $friend){
            if($key % 5 === 0){
                $index++;
            }

            $this->friendsList[$index][] = $friend;
            $this->selectedFriendsIds[] = $friend['id'];
        }
    }

    public function render()
    {
        return view('livewire.forms.form-step12');
    }
}
