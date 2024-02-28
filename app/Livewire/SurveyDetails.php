<?php

namespace App\Livewire;

use App\Models\Survey;
use Livewire\Component;

class SurveyDetails extends Component
{
    public ?Survey $survey = null;

    public function render()
    {
        return view('livewire.survey.components.details', $this->survey);
    }

    //Get & assign selected post props
    public function initData(Survey $survey)
    {
        // assign values to public props
        $this->survey = $survey;
        $this->survey_id = $survey->id;
        $this->survey_code = $survey->survey_code;
        $this->started_at = $survey->started_at;
        $this->finished_at = $survey->finished_at;
        $this->created_at = $survey->created_at;
        $this->updated_at = $survey->updated_at;

        $this->selectedSurvey = [];
    }

    public function mount(Survey $survey)
    {
        $this->survey = $survey;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset(['selectedSurveys', 'bulkDisabled',
            'survey_id',
            'survey_code',
            'started_at',
            'finished_at',
            'created_at',
            'updated_at',
        ]);
    }
}
