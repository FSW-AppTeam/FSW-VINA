<?php

namespace App\Livewire;

use App\Models\SurveyAnswer;
use Livewire\Component;

class SurveyAnswersDetails extends Component
{
    public ?SurveyAnswer $surveyanswers = null;

    public function render()
    {
        return view('livewire.surveyanswers.components.details', $this->surveyanswers);
    }

    //Get & assign selected post props
    public function initData(SurveyAnswer $surveyanswers)
    {
        // assign values to public props
        $this->surveyanswers = $surveyanswers;
        $this->surveyanswers_id = $surveyanswers->id;
        $this->student_id = $surveyanswers->student_id;
        $this->question_id = $surveyanswers->question_id;
        $this->question_type = $surveyanswers->question_type;
        $this->question_title = $surveyanswers->question_title;
        $this->student_answer = $surveyanswers->student_answer;
        $this->created_at = $surveyanswers->created_at;
        $this->updated_at = $surveyanswers->updated_at;

        $this->selectedSurveyAnswers = [];
    }

    public function mount(SurveyAnswer $surveyanswers)
    {
        $this->surveyanswers = $surveyanswers;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset(['selectedSurveyanswerss', 'bulkDisabled',
            'surveyanswers_id',
            'student_id',
            'question_id',
            'question_type',
            'question_title',
            'student_answer',
            'created_at',
            'updated_at',
        ]);
    }
}
