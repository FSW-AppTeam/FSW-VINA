<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswers;
use App\Models\SurveyStudent;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormStep12 extends Component
{
    public PostForm $form;
    public $basicTitle = "";
    public array $friends = [];
    public array $selectedFriendsIds = [];
    public $lastSelectedFriendId = '';

    public $disappear = false;

    public array $students = [];
    public array $startFriend = [];
    public array $finishedFriend = [];

    public int $stepId;
    public $nextEnabled;
    public $backEnabled;

    public \stdClass $jsonQuestion;

    public $firstRequired = true;

    public $studentCounter = 1;

    protected array $messages = [];
    public $index = 0;

    protected $listeners = [
        'set-selected-student-id-comp' => 'setSelectedStudentId',
        'remove-selected-student-id' => 'removeSelectedStudentId',
        'set-sub-step-id-down' => 'stepDown',
        'set-sub-step-id-up' => 'stepUp',
        'set-save-answer' => 'save',
    ];

    public function setSelectedStudentId(int $id, string $name): void
    {
        $this->friends[] = ['id' => $id, 'name' => $name];
        $this->selectedFriendsIds[] = $id;
        $this->lastSelectedFriendId = $id;
    }

    public function removeSelectedStudentId(int $id): void
    {
        $key = array_search($id, array_column($this->friends, 'id'));
        if(is_int($key)){
            array_splice($this->friends, $key, 1);
            array_splice($this->selectedFriendsIds, $key, 1);
            $this->dispatch('set-disable-student-fade-btn',  $id)->component('StudentFadeComponent');
        }
    }

    public function rules(): array
    {
        $this->messages['friends.required'] = $this->jsonQuestion->question_options->error_empty_text;

        return [
            'friends' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->firstRequired) {
                        $this->firstRequired = false;
                        if (empty($value)) {
                            $this->dispatch('set-enable-next');
                            $fail($this->messages['friends.required']);
                        }
                    }
                },
                'array'
            ]
        ];
    }

    public function save(): void
    {
        $this->disappear = false;

        if (session::has('survey-id')) {
            $answer = [
                'student_id' => $this->startFriend['id'],
                'value' => array_column($this->friends, 'id'),
            ];
            $this->form->createAnswer($answer, $this->jsonQuestion, $this->stepId);
            $this->disappear = false;

            if(array_key_exists(1, $this->students)){
                $this->studentCounter ++;

                foreach ($this->selectedFriendsIds as $id){
                    $this->dispatch('set-disable-student-fade-btn',  $id)->component('StudentFadeComponent');
                }

                $this->friends = [];
                $this->selectedFriendsIds = [];
                $this->startFriend = array_shift($this->students);
                $this->finishedFriend[] = $this->startFriend;
                $this->jsonQuestion->question_title = $this->basicTitle . " ID:" .  $this->startFriend['id'];
                $this->setDatabaseResponse();
                $this->dispatch('set-enable-next');
            } else {
                $this->disappear = false;
                $this->dispatch('set-step-id-up');
            }
        }
    }

    public function stepDown(): void
    {
        $this->disappear = false;
        if($this->studentCounter <= 1) {
            $this->dispatch('set-step-id-down');
            return;
        }
        $this->friends = [];
        if(!empty($this->finishedFriend)) {
            array_unshift($this->students, array_pop($this->finishedFriend));
            $this->startFriend = end($this->finishedFriend);
            $this->jsonQuestion->question_title = $this->basicTitle . " ID:" .  $this->startFriend['id'];
        }
        $this->selectedFriendsIds = [];
        $this->setDatabaseResponse();
        $this->studentCounter --;
    }

    public function stepUp(): void
    {
        $this->dispatch('set-disable-next');
        $this->disappear = true;
        $this->dispatch('start-friend-bounce');
    }

    public function mount(): void
    {
        $this->basicTitle = $this->jsonQuestion->question_title;
        $this->students = $this->form->getStudentsWithoutActiveStudent();

        $this->startFriend = array_shift($this->students);
        $this->finishedFriend[] = $this->startFriend;
        $this->jsonQuestion->question_title = $this->basicTitle . " ID:" .  $this->startFriend['id'];
        $this->setDatabaseResponse();
        $this->lastSelectedFriendId = '';
    }

    public function render()
    {
        return view('livewire.forms.form-step12');
    }

    public function setDatabaseResponse()
    {
        $response = SurveyAnswers::where('student_id', $this->form->getStudent()->id)
            ->where('question_id', $this->stepId)
            ->whereJsonContains('student_answer->student_id', $this->startFriend['id'])
            ->first();
        if(!$response) {
            Log::info('NIET gevonden' . $this->startFriend['id'] );
            return;
        }

        foreach ($response->student_answer['value'] as $responseItem) {
            $student = SurveyStudent::find($responseItem);
            if($student) {
                $this->setSelectedStudentId($responseItem, $student->name);
            }
        }
    }
}
