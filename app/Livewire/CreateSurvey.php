<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateSurvey extends Component
{
    public $update;

    public $stepId = 1;

    public $success = false;

    public $jsonQuestion;

    public $student;

    protected $listeners = ['postAdded' => '$refresh', 'setStepIdUp' => 'setStepIdUp'];

    public function refreshComponent(): void
    {
        $this->update = !$this->update;
    }

    public function getJsonQuestion(int $i): void
    {
        $this->jsonQuestion = json_decode(file_get_contents(storage_path("app/surveys/q-$i.json")), FALSE);
    }

    public function update()
    {
        session()->flash('message', 'UPDATED!!! updated successfully!');

        $this->getJsonQuestion($this->stepId);
    }

    public function mount()
    {
        $this->getJsonQuestion($this->stepId);

        session()->flash('message', 'Post mounted!');
    }

    public function setStepIdUp()
    {
        $this->stepId ++;

        $this->getJsonQuestion($this->stepId);
    }

    public function setStepIdDown(): void
    {
        $this->stepId --;

        $this->getJsonQuestion($this->stepId);
    }

//    public function save(): void
//    {
////        dd('save from root');
//        $this->dispatch('postAdded', id: $this->stepId);
//    }

    public function render()
    {
        return view('livewire.create-survey');
    }
}
