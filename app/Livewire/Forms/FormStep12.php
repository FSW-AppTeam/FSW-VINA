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

    protected $listeners = [
        'set-selected-student-id-comp' => 'setSelectedStudentId',
        'remove-selected-student-id' => 'removeSelectedStudentId',
    ];

    public function setSelectedStudentId(int $id, string $name): void
    {
        $this->friends[] = ['id' => $id, 'name' => $name ];

        $this->selectedFriendsIds[] = $id;
    }

    public function removeSelectedStudentId(int $id): void
    {
        $key = array_search($id, array_column($this->friends, 'id'));

        if(is_int($key)){
            array_splice($this->friends, $key, 1);
            array_splice($this->selectedFriendsIds, $key, 1);
        }
    }

    public function rules(): array
    {
        $this->messages['friends.required'] = $this->jsonQuestion->question_options->error_empty_text;
        $this->messages['friends.min'] = $this->jsonQuestion->question_options->error_one_text;

        return [
            'friends' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired) {
                        $this->firstRequired = false;

                        if (empty($value)) {
                            $fail($this->messages['friends.required']);
                        }

                        if (count($value) === 1) {
                            $fail($this->messages['friends.min']);
                        }
                    }
                },
                'array'
            ],

        ];
    }

    public function save(): void
    {
        $this->validate();

        if (\Session::has('survey-student-class-id')) {
            $answer = [
                'id' => $this->startFriend['id'],
                'value' => array_column($this->friends, 'id'),
                ] ;

            $this->form->createAnswer([$answer], $this->jsonQuestion, $this->stepId);

            \Session::put(['student-friends-frequent' => $this->friends]);

            if(array_key_exists(2, $this->students)){
                $this->startFriend = $this->students[1];
                $this->studentCounter ++;

                $this->friends = [];
                $this->selectedFriendsIds = [];
                $this->jsonQuestion->question_title = $this->basicTitle . " $this->studentCounter";

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

        $this->jsonQuestion->question_title = $this->basicTitle . " $this->studentCounter";
        $this->students = $this->form->getStudentsWithoutActiveStudent();

        if(empty($this->friends)){
            $this->startFriend = $this->students[0];
        }
    }

    public function boot(){
//        echo('boot student here');
    }

    public function update(){
//        dump('update student here');
//        $this->students =  array_shift($this->students);
    }

    public function render()
    {
//        dump('render view formstep12!!!');

        return view('livewire.forms.form-step12')->with(['selectedFriendsIds' => $this->selectedFriendsIds]);
    }
}
