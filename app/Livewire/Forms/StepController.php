<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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
        'next' => 'next',
        'back' => 'back',
        'step-up' => 'stepUp',
        'step-down' => 'stepDown',
        'set-refresh-stepper' => '$refresh',
    ];

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

    public function mount()
    {
        if (! Auth::guest() && Auth::user()->isAdmin() && str_starts_with(Request::path(), 'step/')) {
            return;
        }

        $this->continue();
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

    /**
     * @param $force
     * @return void
     *
     * next is called from the FormButtons component.
     * It saves the current step and moves to the next question, this can be a subquestion instead of next step.
     * The handling of the next step is done in the form which is defined in $this->>activeStep.
     */
    public function next(): void
    {
        $this->dispatch('save')->component($this->activeStep);
    }

    public function stepUp(): void
    {
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

    public function back(): void
    {
        if ($this->hasSubQuestions()) {
            $this->dispatch('set-sub-step-down');

            return;
        }
        $this->stepId--;
        $question = SurveyQuestion::where('order', '<=', $this->stepId)
            ->orderBy('order', 'desc')
            ->where('enabled', true)->first();
        // In case of a question is disabled, skip it. We have to set the order as the new stpId
        $this->stepId = $question->order;
        $this->jsonQuestion = $question;

        $this->setActiveStep($this->jsonQuestion);
    }

    public function hasSubQuestions()
    {
        $subQuestion = ['select_for_subject', 'multiple_students'];
        if (! in_array($this->jsonQuestion->form_type, $subQuestion)) {
            return false;
        }

        return true;
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
            if (in_array($this->jsonQuestion->id, [36, 38, 39, 40, 41, 42])) {
                $this->checkNationality();
            }
            if ($this->jsonQuestion->id == 38) {
                $this->checkDependingQuestion38();
            }
            if ($this->jsonQuestion->id == 49) {
                $this->checkDependingQuestion49();
            }
        }
    }

    // Specific logic for question id 38
    private function checkDependingQuestion38()
    {
        if (empty($this->form->getStudentsOtherEthnicityWithResponse($this->jsonQuestion->depends_on_question))) {
            // Skip this question when the depending question has no answer
            $this->stepId++;
            $this->setQuestion();
        }
    }

    // Specific logic for question id 38
    private function checkDependingQuestion49()
    {
        if (empty($this->form->getStudentsFotQuestion49($this->jsonQuestion->depends_on_question))) {
            // Skip this question when the depending question has no answer
            $this->stepId++;
            $this->setQuestion();
        }
    }
    // Specific logic for question id 36
    private function checkNationality()
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
        if ($savedAnswer->student_answer['country_id'] == null) {
            $this->stepId++;
            $this->setQuestion();
            return true;
        }

        switch ($savedAnswer->student_answer['country_id']) {
            case 1:
                // Only Dutch, zo no questions about different backgrounds. Skip to next question
                $this->stepId++;
                $this->setQuestion();
                break;
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
