<?php

namespace App\Livewire\Partials;

use Livewire\Component;

class StudentsButtons extends Component
{
    public $disappear;

    public $subject;

    public $students;

    public $showShrink;

    public $centerSubject = false;

    protected $listeners = [
        'refreshStudentButtons' => '$refresh',

    ];

    public function render()
    {
        return view('livewire.partials.students-buttons');
    }
}
