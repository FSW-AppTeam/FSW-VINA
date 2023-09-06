<?php

namespace App\Livewire\Forms;

use App\Models\SurveyStudent;
use File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;

class StepController extends Component
{
    public $activeStep = 'forms.form-step-intro';

    public $jsonQuestion;

    public $stepId = 0;
    public $success = false;

    public $studentId;

    protected $steps;

    protected $listeners = [
        'postAdded' => '$refresh',
        'set-step-id-up' => 'setStepIdUp',
        'set-step-id-down' => 'setStepIdDown',
    ];

    public function next()
    {
        $currentIndex = array_search($this->activeStep, $this->steps);
        $this->activeStep = ($currentIndex + 1) >= count($this->steps) ? $this->steps[$currentIndex] : $this->steps[$currentIndex + 1];
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
        if(file_exists(storage_path("app/surveys/q-$i.json"))){
            $this->jsonQuestion = json_decode(file_get_contents(storage_path("app/surveys/q-$i.json")), FALSE);
        }
    }

    public function getJsonIntro(): void
    {
        $this->jsonQuestion = json_decode(file_get_contents(storage_path("app/surveys/q-intro.json")), FALSE);
    }

    public function getJsonOutro(int $i): void
    {
        $this->jsonQuestion = json_decode(file_get_contents(storage_path("app/surveys/q-outro.json")), FALSE);
    }

    public function booted()
    {
//        $this->setFormSteps();

        $this->steps = [
            'forms.form-step-intro',
            'forms.form-step1',
            'forms.form-step2',
            'forms.form-step3',
            'forms.form-step4',
            'forms.form-step5',
            'forms.form-step6',
            'forms.form-step7',
            'forms.form-step8',
            'forms.form-step9',
            'forms.form-step10',
        ];
    }

    public function mount()
    {
//        $this->getJsonQuestion($this->stepId);
        $this->getJsonIntro();

        dump('Steps mounted!!' . $this->stepId);

        session()->flash('message', 'Survey mounted -- ' . $this->stepId);
    }

    protected function setFormSteps(): void
    {
        $steps = [];
        $path = resource_path('views/livewire/forms');
        $files = File::allFiles($path);

        foreach ($files as $file){
         $name = $file->getFilenameWithoutExtension(); // remove .php
         $name = substr($name, 0, -6); // remove .blade

            if(str_starts_with($name, 'form-step')){
                $steps[] = 'forms.' . $name;
            }
        }

//        dump($steps);
//        dump($files);
//        dump($this->steps);
    }

    public function setStepIdUp(): void
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
