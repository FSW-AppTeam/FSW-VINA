<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswers;
use Livewire\Component;

class FormStep10 extends Component
{
    public PostForm $form;

    public $friends = [];
    public string $newReligion = "";

    public $stepId;

    public $jsonQuestion;

    protected $rules = [
        'friends' => 'required',
    ];

    protected $messages = [
        'friends.required' => 'Kies minimaal 1 vriend',
    ];

    protected $listeners = [
        'set-selected-student-id' => 'setSelectedStudentId',
    ];

    public function setSelectedStudentId(int $id, string $name): void
    {
        $this->friends[] = ['id' => $id, 'name' => $name ];
    }

    public function save(): void
    {
//        $this->validate();

        if (\Session::has('survey-student-class-id')) {
            $this->form->createAnswer([$this->friends], $this->jsonQuestion, $this->stepId);

            \Session::put(['student-own-friends-basic' => $this->friends]);

            $this->dispatch('set-step-id-up');
        }
    }

    public function mount(): void
    {
//        $this->friends = old('friends') ?? \Session::get('student-own-friends-basic');
    }

    public function render()
    {
        return view('livewire.forms.form-step10');
    }
}
