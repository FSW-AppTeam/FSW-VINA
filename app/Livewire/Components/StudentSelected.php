<?php

namespace App\Livewire\Components;

use Livewire\Component;

class StudentSelected extends Component
{
    public $rowSelectedStudents = [];

    public $selectedStudents;

    public $subject;

    protected $listeners = [
    ];

    public function removeSelectedStudent($id): void
    {
        $this->dispatch('remove-selected-student-id', $id);
    }

    public function mount()
    {
        $this->setRowSelectedStudents();
    }

    public function render()
    {
        return view('livewire.components.student-selected');
    }

    public function setRowSelectedStudents()
    {
        $this->appendSubject();

        $selected = $this->selectedStudents;
        $rows = (int) ceil(count($selected) / 5);
        for ($i = 0; $i < $rows; $i++) {
            $this->rowSelectedStudents[$i + 1] = array_slice($selected, $i * 5, 5);
        }

    }

    public function appendSubject()
    {
        if (! $this->subject) {
            return;
        }

        $subject = $this->subject;

        if (! array_search($this->subject['id'], array_column($this->selectedStudents, 'id'))) {
            array_unshift($this->selectedStudents, $subject);
        }

    }
}
