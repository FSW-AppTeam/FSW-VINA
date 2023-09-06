<?php

namespace App\Livewire;

use App\Models\SurveyStudent;
use Livewire\Component;

class Students extends Component
{
    public $classId;

    public function render()
    {
        return view('livewire.students')->with([
            'students' => SurveyStudent::where('class_id', $this->classId)->get()->toArray(),
        ]);
    }

    public function mount()
    {
        $this->classId = \Session::get('survey-student-class-id');
    }
}
