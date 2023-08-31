<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class StepController extends Component
{
    public $activeStep = 'forms.form-step1';

    public $jsonQuestion;

    public $stepId = 1;
    public $success = false;

    protected $steps = [
        'forms.form-step1',
        'forms.form-step2',
        'forms.form-step3',
    ];

    protected $listeners = [
        'postAdded' => '$refresh',
        'set-step-id-up' => 'setStepIdUp',
        'set-step-id-down' => 'setStepIdDown',
    ];

    public function next()
    {
        $currentIndex = array_search($this->activeStep, $this->steps);
        $this->activeStep = ($currentIndex + 1) > count($this->steps) ? $this->steps[$currentIndex] : $this->steps[$currentIndex + 1];
    }

    public function back()
    {
        $currentIndex = array_search($this->activeStep, $this->steps);
        $this->activeStep = ($currentIndex - 1) < 0 ? $this->steps[$currentIndex] : $this->steps[$currentIndex -1];
    }

    public function refreshComponent(): void
    {
        $this->update = !$this->update;
    }

    public function getJsonQuestion(int $i): void
    {
        $this->jsonQuestion = json_decode(file_get_contents(storage_path("app/surveys/q-$i.json")), FALSE);
    }

    public function mount()
    {
        $this->getJsonQuestion($this->stepId);

        dump('Steps mounted!!' . $this->stepId);

        session()->flash('message', 'Survey mounted -- ' . $this->stepId);
    }

    public function setStepIdUp()
    {
        $this->next();
        $this->stepId ++;
        $this->getJsonQuestion($this->stepId);
    }

    public function setStepIdDown(): void
    {
        $this->back();
        $this->stepId --;
        $this->getJsonQuestion($this->stepId);
    }

    public function render()
    {
        return view('livewire.forms.step-controller');
    }
}
