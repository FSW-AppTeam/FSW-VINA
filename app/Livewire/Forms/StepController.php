<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
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

    public $questionOptions = [];

    public $steps;

    protected $listeners = [
        'set-step-id-up' => 'setStepIdUp',
        'set-step-id-down' => 'setStepIdDown',
        'set-refresh-stepper' => '$refresh',
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
        $question = SurveyQuestion::where('order', '<=', $this->stepId)
            ->orderBy('order', 'desc')
            ->where('enabled', true)->first();

        // In case of a question is disabled, skip it. We have to set the order as the new stpId
        $this->stepId = $question->order;
        $this->jsonQuestion = $question;
        $this->setSavedAnswers();
        if ($this->stepId == 0) {
            $this->getJsonIntro();
        }

        $this->setActiveStep($question);
    }

    public function refreshComponent(): void
    {
        $this->update = ! $this->update;
    }

    public function getJsonIntro(): void
    {
        $this->jsonQuestion = json_decode(file_get_contents(resource_path('surveys/q-intro.json')), false);
    }

    public function getJsonOutro(int $i): void
    {
        $this->jsonQuestion = json_decode(file_get_contents(resource_path('surveys/q-outro.json')), false);
    }

    public function boot()
    {
//        $this->continue();
    }

    public function continue()
    {
        if (Session::has('student-name') && Session::has('student-id') && Session::has('survey-id')) {
            $answers = SurveyAnswer::where('student_id', Session::get('student-id'))
                ->pluck('question_id')->toArray();
            if ($answers) {
                $lastQuestion = SurveyQuestion::whereIn('id', $answers)
                    ->orderBy('order', 'desc')->first();
                $this->stepId = $lastQuestion->order;
            }
        }
        $question = SurveyQuestion::where('order', '>=', $this->stepId)
            ->orderBy('order', 'asc')
            ->where('enabled', true)->first();
        // In case of a question is disabled, skip it. We have to set the order as the new stpId
        $this->stepId = $question->order;
        $this->jsonQuestion = $question;
        $this->setSavedAnswers();
        if ($this->stepId == 0) {
            $this->getJsonIntro();
        }

        $this->setActiveStep($this->jsonQuestion);
    }

    public function setStepIdUp(): void
    {
        $this->next();
        $this->stepId++;

        $question = SurveyQuestion::where('order', '>=', $this->stepId)
            ->orderBy('order', 'asc')
            ->where('enabled', true)->first();
        if ($question) {
            // In case of a question is disabled, skip it. We have to set the order as the new stpId
            $this->stepId = $question->order;
            $this->jsonQuestion = $question;
        }
        $this->setActiveStep($this->jsonQuestion);
    }

    public function setStepIdDown(): void
    {
        $this->back();
        $this->stepId--;

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
        $this->setQuestion();
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
            // If formtype is set, a dynamic form is used.
            $this->activeStep = 'forms.form-step-'.$jsonQuestion->form_type;

            return;
        }

        if (! isset($jsonQuestion->id)) {
            $this->activeStep = 'forms.form-step-outro';

            return;
        }

        $this->activeStep = 'forms.form-step-'.$jsonQuestion->id;
    }

    public function setSavedAnswers(): void
    {
        $this->savedAnswers = null;
        $savedAnswer = SurveyAnswer::where('question_id', $this->jsonQuestion->id)
            ->where('student_id', Session::get('student-id'));

        if ($savedAnswer->exists()) {
            $this->savedAnswers = $savedAnswer->first()->student_answer;
        }
    }

    public function setQuestion()
    {
        $question = SurveyQuestion::where('order', '>=', $this->stepId)
            ->orderBy('order', 'asc')
            ->where('enabled', true)->first();
        // In case of a question is disabled, skip it. We have to set the order as the new stpId
        $this->stepId = $question->order;
        $this->jsonQuestion = $question;

        if (isset($this->jsonQuestion->depends_on_question)) {
            if ($this->jsonQuestion->id == 36) {
                $this->stepQuestionId36();
            }
            if ($this->jsonQuestion->id == 37 || $this->jsonQuestion->id == 38) {
                $this->stepQuestionId37();
            }
        }
    }

    // Specific logic for question id 37 and 38
    private function stepQuestionId37()
    {
        if(empty($this->form->getStudentsWithResponse($this->jsonQuestion->depends_on_question))){
            $this->stepId++;
            return $this->setQuestion();
        }
    }

    // Specific logic for question id 36
    private function stepQuestionId36()
    {
        $savedAnswer = SurveyAnswer::where('question_id', $this->jsonQuestion->depends_on_question)
            ->where('student_id', Session::get('student-id'))
            ->first();
        $dependsOnQuestion = SurveyQuestion::find($this->jsonQuestion->depends_on_question);
        foreach ($dependsOnQuestion->question_answer_options as $option) {
            if ($option['id'] == $savedAnswer->student_answer['country_id']) {
                $otherCountry = $option['value'];
            }
        }
        switch ($savedAnswer->student_answer['country_id']) {
            case 1:
                $this->stepId++;

                return $this->setQuestion();
            case 2:
            case 3:
            case 4:
                return $this->questionOptions = getCountriesByName()[$otherCountry];
            case 5:
                return $this->questionOptions = getCountriesByName()['Nederlandse Antillen'];
            case 6:
                return $this->questionOptions = getCountriesByName()[$savedAnswer->student_answer['other_country']];
            default:
                return false;
        }
    }
}
