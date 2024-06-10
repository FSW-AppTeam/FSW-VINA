<?php

namespace App\Livewire;

use Livewire\Component;

class CreateSurvey extends Component
{
    public $update;

    public $stepId;

    public function mount()
    {
        // set stepId to the value of the stepId query parameter. This is for testing purposes.
        // the url step/1 will set the stepId to 1 and is only available for login users.
        $this->stepId = request('stepId', 0);
    }

    public function render()
    {
        return view('livewire.create-survey');
    }
}
