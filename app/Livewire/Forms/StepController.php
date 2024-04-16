<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
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
    public $savedAnswers;

    public $jsonQuestion;

    public $steps;

    protected $listeners = [
        'set-step-id-up' => 'setStepIdUp',
        'set-step-id-down' => 'setStepIdDown',
        'set-refresh-stepper'  => '$refresh',
    ];

    public function next()
    {
        $question = SurveyQuestion::where('order', '>=', $this->stepId + 1)
            ->orderBy('order', 'asc')
            ->where('enabled', true)
            ->first();

        $this->setActiveStep($question);
    }

    public function back()
    {
        $question = SurveyQuestion::where('order', '<=', $this->stepId - 1)
            ->orderBy('order', 'desc')
            ->where('enabled', true)->first();
        $this->setActiveStep($question);
    }

    public function refreshComponent(): void
    {
        $this->update = !$this->update;
    }

    public function getJsonIntro(): void
    {
        $this->jsonQuestion = json_decode(file_get_contents(resource_path("surveys/q-intro.json")), FALSE);
    }

    public function getJsonOutro(int $i): void
    {
        $this->jsonQuestion = json_decode(file_get_contents(resource_path("surveys/q-outro.json")), FALSE);
    }

    public function boot()
    {
        $this->jsonQuestion = SurveyQuestion::where('order', $this->stepId)->where('enabled', true)->first();
        if($this->stepId == 0) {
            $this->getJsonIntro();
        }

        $this->setActiveStep($this->jsonQuestion);
    }

    public function continue()
    {
        if(Session::has('student-name') && Session::has('student-id') && Session::has('survey-id')) {
            $answers = SurveyAnswer::where('student_id', Session::get('student-id'))
                ->pluck('question_id')->toArray();
            if($answers) {
                $lastQuestion = SurveyQuestion::whereIn('id', $answers)
                    ->orderBy('order', 'desc')->first();
                $this->stepId = $lastQuestion->order;
            }
        }
        $this->jsonQuestion = SurveyQuestion::where('order', $this->stepId)->where('enabled', true)->first();
        $this->setSavedAnswers();
        if($this->stepId == 0) {
            $this->getJsonIntro();
        }

        $this->setActiveStep($this->jsonQuestion);
    }

    public function setStepIdUp(): void
    {
        $this->next();
        $this->stepId ++;

        $question = SurveyQuestion::where('order', '>=', $this->stepId)
            ->orderBy('order', 'asc')
            ->where('enabled', true)->first();

        if($question) {
            // In case of a question is disabled, skip it. We have to set the order as the new stpId
            $this->stepId = $question->order;
            $this->jsonQuestion = $question;
        }
        $this->setActiveStep($this->jsonQuestion);
    }

    public function setStepIdDown(): void
    {
        $this->back();
        $this->stepId --;

        $question = SurveyQuestion::where('order', '<=', $this->stepId)
            ->orderBy('order', 'desc')
            ->where('enabled', true)->first();
        // In case of a question is disabled, skip it. We have to set the order as the new stpId
        $this->stepId = $question->order;
        $this->jsonQuestion = $question;

        $this->setActiveStep($this->jsonQuestion);
    }

    public function setEnabledNext(): void
    {
        $this->nextEnabled = true;
        if ($this->jsonQuestion->default_disable_next) {
            $this->nextEnabled = false;
        }
    }

    public function setEnabledBack(): void
    {
        $this->backEnabled = true;
    }

    public function render()
    {
        $this->setActiveStep($this->jsonQuestion);
        $this->setSavedAnswers();
        $this->setEnabledNext();
        $this->setEnabledBack();

        return view('livewire.forms.step-controller');
    }

    public function setActiveStep($jsonQuestion): void
    {
        if ($this->stepId == 0) {
            $this->activeStep = 'forms.form-step-intro';
            return;
        }

        if (isset($jsonQuestion->form_type)) {
            $this->activeStep = 'forms.form-step-' . $jsonQuestion->form_type;
            return;
        }

        if (!isset($jsonQuestion->id)) {
            $this->activeStep = 'forms.form-step-outro';
            return;
        }
        $this->activeStep = 'forms.form-step-' . $jsonQuestion->id;
    }
    public function setSavedAnswers(): void
    {
        $this->savedAnswers = null;
        $savedAnswer = SurveyAnswer::where('question_id', $this->jsonQuestion->id)
            ->where('student_id', Session::get('student-id'));

        if($savedAnswer->exists()) {
            $this->savedAnswers =  $savedAnswer->first()->student_answer;
        }
    }
}
