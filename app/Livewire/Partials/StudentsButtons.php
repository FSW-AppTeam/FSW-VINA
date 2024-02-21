<?php

namespace App\Livewire\Partials;

use App\Livewire\Forms\FormStep15;
use Livewire\Component;

class StudentsButtons extends Component
{
    public $disappear;
    public $startStudent;
    public $students;

    protected $listeners = [
        'set-disapear-false'  => 'setDisapearFalse',
        'set-disapear-true'  => 'setDisapearTrue',
        'refreshStudentButtons' => '$refresh'

    ];

    public function render()
    {
        return view('livewire.partials.students-buttons');
    }

    public function setDisapearTrue()
    {
        $this->disappear = true;
    }

    public function setDisapearFalse()
    {
        $this->disappear = false;
    }
}
