<?php

namespace App\Livewire\Forms;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

/**
 * Controlling the pages from the survey
 */
class StepController extends Component
{
    public PostForm $form;
    public $activeStep = 'forms.form-step-intro';
    public $stepId = 0;
    public $nextEnabled = false;
    public $backEnabled = false;
    public $defaultEnabledNext = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 17, 21];


    public $jsonQuestion;

    public $jsonQuestionNameList = [];

    public $steps;

    protected $listeners = [
        'set-step-id-up' => 'setStepIdUp',
        'set-step-id-down' => 'setStepIdDown',
        'set-refresh-stepper'  => '$refresh',
    ];

    public function next()
    {
        $currentIndex = array_search($this->activeStep, $this->steps);
        $this->activeStep = ($currentIndex + 1) >= count($this->steps) ? $this->steps[$currentIndex] : $this->steps[$currentIndex + 1];
    }

    public function back()
    {
        $currentIndex = array_search($this->activeStep, $this->steps);
        $this->activeStep = ($currentIndex - 1) < 0 ? $this->steps[$currentIndex] : $this->steps[$currentIndex - 1];
    }

    public function refreshComponent(): void
    {
        $this->update = !$this->update;
    }

    public function getJsonQuestion(int $i): void
    {
        if(file_exists(resource_path("surveys/q-$i.json"))){
            $this->jsonQuestion = json_decode(file_get_contents(resource_path("surveys/q-$i.json")), FALSE);
        }
    }

    public function getJsonNameList(): void
    {
        $this->jsonQuestionNameList = json_decode(file_get_contents(resource_path("surveys/prefilled-names.json")), FALSE);
    }

    public function getJsonIntro(): void
    {
        $this->jsonQuestion = json_decode(file_get_contents(resource_path("surveys/q-intro.json")), FALSE);
    }

    public function getJsonOutro(int $i): void
    {
        $this->jsonQuestion = json_decode(file_get_contents(storage_path("app/surveys/q-outro.json")), FALSE);
    }

    public function boot()
    {
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
            'forms.form-step11',
            'forms.form-step12',
            'forms.form-step13',
            'forms.form-step14',
            'forms.form-step15',
            'forms.form-step16',
            'forms.form-step17',
            'forms.form-step18',
            'forms.form-step19',
            'forms.form-step20',
            'forms.form-step21',
            'forms.form-step22',
            'forms.form-step23',
            'forms.form-step24',
            'forms.form-step25',
            'forms.form-step26',
            'forms.form-step27',
            'forms.form-step28',
            'forms.form-step29',
            'forms.form-step30',
            'forms.form-step31',
            'forms.form-step32',
        ];

        $this->setDefaultActiveStep();
    }

    public function mount()
    {
        $this->getJsonIntro();
        $this->getJsonNameList();

        if($this->jsonQuestionNameList->active_list){
            $this->form->createStudentListFromJson($this->jsonQuestionNameList);
        }
    }

//    not using, maybe future
//    protected function setFormSteps(): void
//    {
//        $steps = [];
//        $path = resource_path('views/livewire/forms');
//        $files = File::allFiles($path);
//
//        foreach ($files as $file){
//         $name = $file->getFilenameWithoutExtension(); // remove .php
//         $name = substr($name, 0, -6); // remove .blade
//
//            if(str_starts_with($name, 'form-step')){
//                $steps[] = 'forms.' . $name;
//            }
//        }
//    }

    public function setStepIdUp(): void
    {
        $this->next();
        $this->stepId ++;
        $this->setDefaultActiveStep();
    }

    public function setStepIdDown(): void
    {
        $this->back();
        $this->stepId --;

        if(is_null(\Session::get('student-origin-country')) && ($this->stepId === 7)){  // skip question 8
            $this->back();
            $this->stepId --;
        }
        $this->setDefaultActiveStep();
    }

    public function setEnabledNext(): void
    {
        if (in_array($this->stepId, $this->defaultEnabledNext)){
            $this->nextEnabled = true;
        }
    }

    public function setEnabledBack(): void
    {
        $this->backEnabled = true;
    }

    public function render()
    {
        $this->getJsonQuestion($this->stepId);

        $this->setEnabledNext();
        $this->setEnabledBack();

        return view('livewire.forms.step-controller');
    }

    public function setDefaultActiveStep(): void
    {
        if(!session::has('student-id')){
            $this->stepId = 2;
        }

        if($this->stepId >= 2 && !session::has('survey-id')){
            $this->stepId = 1;
        }

        $this->activeStep = $this->steps[$this->stepId];
    }
}
