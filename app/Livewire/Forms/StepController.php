<?php

namespace App\Livewire\Forms;

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\Survey;
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

    public $loading = true;

    public $savedAnswers;

    public $jsonQuestion;

    public $questionOptions = [];

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

     #[Computed(persist: true)]
    public function getSurvey(): Survey
    {
        return Survey::find(session::get('survey-id'));
    }


    public function mount()
    {
        // set stepId to the value of the stepId query parameter. This is for testing purposes.
        // the url step/1 will set the stepId to 1 and is only available for login users.
        $this->stepId = request('stepId', 0);

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
            // name and survey id are set. But when no other answers are set, we start at the first question (step 3).
            $this->stepId = 3;
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
     * @param  $force
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
        if (($this->jsonQuestion->id ?? null) === 57 || Session::get('survey-ineligible')) {
            $returnQuestionId = Session::get('survey-ineligible-return-question', 7);
            Session::forget('survey-ineligible');
            Session::forget('survey-ineligible-return-question');
            $this->jsonQuestion = SurveyQuestion::findOrFail($returnQuestionId);
            $this->stepId = $this->jsonQuestion->order;
            $this->setActiveStep($this->jsonQuestion);
            $this->setSavedAnswers();

            return;
        }

        if ($this->hasSubQuestions()) {
            $this->dispatch('set-sub-step-down');

            return;
        }

        $this->stepId--;
        $question = SurveyQuestion::where('order', '<=', $this->stepId)
            ->orderBy('order', 'desc')
            ->where('enabled', true)->first();

        while ($question && $this->shouldSkipQuestion($question)) {
            $question = SurveyQuestion::where('order', '<', $question->order)
                ->orderBy('order', 'desc')
                ->where('enabled', true)->first();
        }

        // In case of a question is disabled, skip it. We have to set the order as the new stpId
        $this->stepId = $question->order;
        $this->jsonQuestion = $question;

        $this->setActiveStep($this->jsonQuestion);
    }

    public function stepDown(): void
    {
        $this->stepId--;
        $question = SurveyQuestion::where('order', '<=', $this->stepId)
            ->orderBy('order', 'desc')
            ->where('enabled', true)
            ->whereHas('surveyAnswers', function ($q) {
                $q->whereNotNull('student_answer')
                    ->where('student_id', session('student-id'));
            })->first();

        if ($question) {
            // In case of a question is disabled, skip it. We have to set the order as the new stpId
            $this->stepId = $question->order;
            $this->jsonQuestion = $question;
        }

        $this->setActiveStep($this->jsonQuestion);
    }

    public function hasSubQuestions()
    {
        $subQuestion = ['select_for_subject', 'multiple_students', 'select_multiple'];
        if (! in_array($this->jsonQuestion->form_type, $subQuestion)) {
            return false;
        }

        return true;
    }

    public function setEnabledNext(): void
    {
        $this->loading = false;
        if ($this->jsonQuestion->default_disable_next) {
            $this->loading = true;
        }
    }

    public function setEnabledBack(): void
    {
        $this->loading = true;
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

        if ($this->isLastQuestion()) {
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
        if (Session::get('survey-ineligible')) {
            $this->jsonQuestion = SurveyQuestion::findOrFail(57);
            $this->stepId = $this->jsonQuestion->order;
            $this->activeStep = 'forms.form-step-display';

            return;
        }

        $question = SurveyQuestion::where('order', '>=', $this->stepId)
            ->orderBy('order', 'asc')
            ->where('enabled', true)
            ->first();
        // In case of a question is disabled, skip it. We have to set the order as the new stpId
        $this->stepId = $question->order;
        $this->jsonQuestion = $question;

        if ($this->shouldSkipQuestion($this->jsonQuestion)) {
            $this->stepId++;
            $this->setQuestion();

            return;
        }

        if (isset($this->jsonQuestion->depends_on_question)) {

            if ($this->getSurvey()->usesFriends() and !$this->jsonQuestion->id === 36){
                return;
            }

            if (in_array($this->jsonQuestion->id, [36, 40, 41, 42, 50, 51, 52])) {

                $savedAnswer = SurveyAnswer::where('question_id', $this->jsonQuestion->depends_on_question)
                    ->where('student_id', session('student-id'))
                    ->first();
                if ($savedAnswer->student_answer['country_id'] == 1 ||
                    $savedAnswer->student_answer['country_id'] == 7 ||
                    $savedAnswer->student_answer['country_id'] == null) {
                    // Only Dutch, zo no questions about different backgrounds. Skip to next question
                    $this->stepId++;
                    $this->setQuestion();

                    return;
                }
                
                $this->questionOptions = setNationalityOptions($this->jsonQuestion->depends_on_question);
            }
            if ($this->jsonQuestion->id == 38) {
                $this->checkDependingQuestion38();
            }
            if ($this->jsonQuestion->id == 49) {
                $this->checkDependingQuestion49();
            }
        }
    }

    private function shouldSkipQuestion(SurveyQuestion $question): bool
    {
        if ($question->id === 55 && $question->depends_on_question) {
            $answer = SurveyAnswer::where('question_id', $question->depends_on_question)
                ->where('student_id', session('student-id'))
                ->value('student_answer');

            if ((int) $answer !== 1) {
                return true;
            }
        }

        $usesMigratoryFriends = data_get($question, 'question_options.answers_source') === 'migratory_background'
            || data_get($question, 'question_options.subjects_source') === 'migratory_background';

        if (! $usesMigratoryFriends) {
            return false;
        }

        $survey = Survey::find(session('survey-id'));
        if (! $survey || ! $survey->usesFriends()) {
            return false;
        }

        return data_get($question, 'question_options.answers_source') === 'migratory_background'
            ? empty($this->form->getSelectablesForQuestion($question))
            : empty($this->form->getSubjectsForQuestion($question));
    }

    // Specific logic for question id 38
    private function checkDependingQuestion38()
    {
        $selectables = $this->getSurvey()->usesFriends()
            ? $this->form->getSelectablesForQuestion($this->jsonQuestion)
            : $this->form->getStudentsOtherEthnicityWithResponse($this->jsonQuestion->depends_on_question);

        if (empty($selectables)) {
            // Skip this question when the depending question has no answer
            $this->stepId++;
            $this->setQuestion();
        }
    }

    // Specific logic for question id 49
    private function checkDependingQuestion49()
    {
        if (empty($this->form->getStudentsFotQuestion49($this->jsonQuestion->depends_on_question))) {
            // Skip this question when the depending question has no answer
            $this->stepId++;
            $this->setQuestion();
        }
    }

    private function isLastQuestion(): bool
    {
        $lastQuestion = SurveyQuestion::orderBy('order', 'desc')->first();
        if ($this->stepId == $lastQuestion->order) {
            return true;
        }

        return false;
    }
}
