<?php

namespace App\Livewire;

use App\Models\SurveyQuestion;
use Livewire\Component;

class SurveyQuestionDetails extends Component
{
    public ?SurveyQuestion $surveyquestion = null;

    public function render()
    {
        return view('livewire.surveyquestion.components.details', $this->surveyquestion);
    }

    //Get & assign selected post props
    public function initData(SurveyQuestion $surveyquestion)
    {
        // assign values to public props
        $this->surveyquestion = $surveyquestion;
        $this->surveyquestion_id = $surveyquestion->id;
        $this->order = $surveyquestion->order;
        $this->question_type = $surveyquestion->question_type;
        $this->question_title = $surveyquestion->question_title;
        $this->question_content = $surveyquestion->question_content;
        $this->question_answer_options = $surveyquestion->question_answer_options;
        $this->question_options = $surveyquestion->question_options;
        $this->created_at = $surveyquestion->created_at;
        $this->updated_at = $surveyquestion->updated_at;

        $this->selectedSurveyQuestion = [];
    }

    public function mount(SurveyQuestion $surveyquestion)
    {
        $this->surveyquestion = $surveyquestion;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset(['selectedSurveyquestions', 'bulkDisabled',
            'surveyquestion_id',
            'order',
            'question_type',
            'question_title',
            'question_content',
            'question_answer_options',
            'question_options',
            'created_at',
            'updated_at',
        ]);
    }
}
