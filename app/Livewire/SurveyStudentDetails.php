<?php

namespace App\Livewire;

use App\Models\SurveyStudent;
use Livewire\Component;

class SurveyStudentDetails extends Component
{
    public ?SurveyStudent $surveystudent = null;

    public function render()
    {
        return view('livewire.surveystudent.components.details', $this->surveystudent);
    }

    //Get & assign selected post props
    public function initData(SurveyStudent $surveystudent)
    {
        // assign values to public props
        $this->surveystudent = $surveystudent;
        $this->surveystudent_id = $surveystudent->id;
        $this->name = $surveystudent->name;
        $this->finished_at = $surveystudent->finished_at;
        $this->exported_at = $surveystudent->exported_at;
        $this->survey_id = $surveystudent->survey_id;
        $this->created_at = $surveystudent->created_at;
        $this->updated_at = $surveystudent->updated_at;

        $this->selectedSurveyStudent = [];
    }

    public function mount(SurveyStudent $surveystudent)
    {
        $this->surveystudent = $surveystudent;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset(['selectedSurveystudents', 'bulkDisabled',
            'surveystudent_id',
            'name',
            'finished_at',
            'exported_at',
            'survey_id',
            'created_at',
            'updated_at',
        ]);
    }
}
